<?php

namespace Briareos\NodejsBundle\Nodejs;

use Briareos\NodejsBundle\Nodejs\Message;
use Briareos\NodejsBundle\Nodejs\DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    private $secure;
    private $host;
    private $port;
    private $connectTimeout;
    private $resource;
    private $serviceKey;
    private $websocketSwfLocation = 'bundles/nodejs/WebSocketMain.swf';

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

    public function __construct($secure = false, $host = 'localhost', $port = 8080, $connectTimeout = 5000, $resource = '/socket.io', $serviceKey = '')
    {
        $this->setSecure($secure);
        $this->setHost($host);
        $this->setPort($port);
        $this->setConnectTimeout($connectTimeout);
        $this->setResource($resource);
        $this->setServiceKey($serviceKey);
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
        curl_setopt_array($ch, array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $message->toJsonString(),
            CURLOPT_CONNECTTIMEOUT => 1,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_HTTPHEADER => array(
                'NodejsServiceKey: ' . $this->getServiceKey(),
            )
        ));
        $return = curl_exec($ch);
        return $return;
    }

    public function getServiceUrl($type = 'message')
    {
        switch ($type) {
            case 'message':
                return 'http://' . $this->getHost() . ':' . $this->getPort() . '/nodejs/publish';
        }
    }
}