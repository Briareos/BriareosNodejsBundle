<?php

namespace Briareos\NodejsBundle\Twig\Extension;

use Briareos\NodejsBundle\Nodejs\DispatcherInterface;
use Briareos\NodejsBundle\Nodejs\Authenticator;
use Symfony\Component\HttpFoundation\Session\Session;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;

class Nodejs extends \Twig_Extension
{
    private $dispatcher;
    private $authenticator;

    public function __construct(DispatcherInterface $dispatcher, Authenticator $authenticator)
    {
        $this->dispatcher = $dispatcher;
        $this->authenticator = $authenticator;
    }

    public function getFunctions()
    {
        return array(
            'socket_io_resource' => new \Twig_Function_Method($this, 'getSocketIoResource')
        );
    }

    public function getSocketIoResource()
    {
        return sprintf('//%s:%s%s/socket.io.js', $this->dispatcher->getHost(), $this->dispatcher->getPort(), $this->dispatcher->getResource());
    }

    public function getName()
    {
        return 'nodejs';
    }
}