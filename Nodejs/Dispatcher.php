<?php

namespace Briareos\NodejsBundle\Nodejs;

use Briareos\NodejsBundle\Nodejs\Message;
use Briareos\NodejsBundle\Nodejs\DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    private $secure;
    private $host;
    private $port;
    private $resource;
    private $serviceKey;
    private $connectTimeout;
    private $websocketSwfLocation = 'bundles/nodejs/WebSocketMain.swf';

    public function __construct($secure = false, $host = 'localhost', $port = 8080, $resource = '/socket.io', $serviceKey = '', $connectTimeout = 5000)
    {
        $this->setSecure($secure);
        $this->setHost($host);
        $this->setPort($port);
        $this->setResource($resource);
        $this->setServiceKey($serviceKey);
        $this->setConnectTimeout($connectTimeout);
    }

    public function setWebsocketSwfLocation($location)
    {
        $this->websocketSwfLocation = $location;
    }

    public function getWebsocketSwfLocation()
    {
        return $this->websocketSwfLocation;
    }

    public function dispatch(Message $message)
    {
        $ch = curl_init($this->getServiceUrl());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message->toJsonString());
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'NodejsServiceKey: ' . $this->getServiceKey(),
        ));
        curl_exec($ch);
    }

    public function getServiceUrl($type = 'message')
    {
        switch ($type) {
            case 'message':
                return 'http://' . $this->getHost() . ':' . $this->getPort() . '/nodejs/publish';
        }
    }

    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }

    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setServiceKey($serviceKey)
    {
        $this->serviceKey = $serviceKey;
    }

    public function getServiceKey()
    {
        return $this->serviceKey;
    }

    public function setSecure($secure)
    {
        $this->secure = $secure;
    }

    public function getSecure()
    {
        return $this->secure;
    }
}