<?php

namespace Briareos\NodejsBundle\Nodejs;

use Briareos\NodejsBundle\Nodejs\Message;

interface DispatcherInterface
{
    public function dispatch(Message $message);

    public function getSecure();

    public function getHost();

    public function getPort();

    public function getConnectTimeout();

    public function getResource();

    public function getServiceKey();

    public function getWebsocketSwfLocation();
}