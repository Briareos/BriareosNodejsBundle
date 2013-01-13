<?php

namespace Briareos\NodejsBundle\Security;

use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Briareos\NodejsBundle\Nodejs\Authenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NodejsInvalidatorLogoutHandler implements LogoutHandlerInterface
{
    private $authenticator;

    function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }


    /**
     * {@inheritdoc}
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $session = $request->getSession();
        if ($session === null) {
            return;
        }
        $user = $token->getUser();
        $this->authenticator->invalidate($session, $user);
    }

}