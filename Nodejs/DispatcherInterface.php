<?php

namespace Briareos\NodejsBundle\Nodejs;

use Briareos\NodejsBundle\Nodejs\Message;

interface DispatcherInterface
{
    public function dispatch(Message $message);

    public function getServiceKey();
}