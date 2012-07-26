<?php

namespace Briareos\NodejsBundle\Twig\Extension;

use Briareos\NodejsBundle\Nodejs\DispatcherInterface;
use Briareos\NodejsBundle\Nodejs\Authenticator;
use Symfony\Component\HttpFoundation\Session\Session;

class Nodejs extends \Twig_Extension
{
    private $dispatcher;
    private $authenticator;

    public function __construct(DispatcherInterface $dispatcher, Authenticator $authenticator)
    {
        $this->dispatcher = $dispatcher;
        $this->authenticator = $authenticator;
    }

    public function getGlobals()
    {
        return array(
            'nodejs' => array(
                'secure' => $this->dispatcher->getSecure(),
                'host' => $this->dispatcher->getHost(),
                'port' => $this->dispatcher->getPort(),
                'connect_timeout' => $this->dispatcher->getConnectTimeout(),
                'resource' => $this->dispatcher->getResource(),
                'websocket_swf_location' => $this->dispatcher->getWebsocketSwfLocation()
            ),
        );
    }

    public function getFunctions()
    {
        return array(
            'nodejs_auth_token' => new \Twig_Function_Method($this, 'getAuthToken'),
        );
    }

    public function getAuthToken(Session $session)
    {
        return $this->authenticator->generateAuthToken($session);
    }

    public function getName()
    {
        return 'nodejs';
    }
}