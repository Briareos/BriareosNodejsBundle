<?php

namespace Briareos\NodejsBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Briareos\NodejsBundle\Nodejs\Authenticator;
use Symfony\Component\HttpFoundation\Request;

class LoginListener
{
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $request = $event->getRequest();
        $user = $event->getAuthenticationToken()->getUser();
        $session = $request->getSession();
        if ($session !== null) {
            $this->authenticator->authenticate($session, $user);
        }
    }
}