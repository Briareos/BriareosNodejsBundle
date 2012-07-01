<?php

namespace Briareos\NodejsBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Briareos\NodejsBundle\Nodejs\Authenticator;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;
use Symfony\Component\HttpFoundation\Request;

class LoginListener
{
    private $securityContext;
    private $authenticator;
    private $request;

    public function __construct(SecurityContextInterface $securityContext, Authenticator $authenticator, Request $request)
    {
        $this->securityContext = $securityContext;
        $this->authenticator = $authenticator;
        $this->request = $request;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $session = $this->request->getSession();
        if ($session !== null) {
            $this->authenticator->authenticate($session, $user);
        }
    }
}