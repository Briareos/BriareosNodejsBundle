<?php

namespace Briareos\NodejsBundle\Nodejs;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;

interface AuthenticatorInterface
{
    /**
     * @param SessionInterface $session
     * @param NodejsSubjectInterface $subject
     * @return string
     */
    public function generateAuthToken(SessionInterface $session, NodejsSubjectInterface $subject = null);

    public function authenticate(SessionInterface $session, NodejsSubjectInterface $subject = null);

    public function invalidate(SessionInterface $session, NodejsSubjectInterface $subject = null);

    /**
     * @param string $authToken
     * @return \Briareos\NodejsBundle\Entity\NodejsPresence
     */
    public function getPresence($authToken);

}