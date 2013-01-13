<?php

namespace Briareos\NodejsBundle\Nodejs;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Authenticator
{
    private $em;

    private $repository;

    private $lifetime;

    public function __construct(EntityManager $em, $presenceClassName, $lifetime)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($presenceClassName);
        $this->lifetime = $lifetime;
    }

    public function authenticate(SessionInterface $session, NodejsSubjectInterface $subject = null)
    {
        $presenceClassName = $this->repository->getClassName();
        $authToken = $this->generateAuthToken($session, $subject);
        /** @var $presence \Briareos\NodejsBundle\Entity\NodejsPresence */
        $presence = $this->repository->findOneBy(
            array(
                'authToken' => $authToken,
            )
        );
        if ($presence === null) {
            $presence = new $presenceClassName();
            $presence->setSessionId($session->getId());
            $presence->setAuthToken($authToken);
            if ($subject !== null) {
                $presence->setSubject($subject);
            }
        }
        $presence->setSeenAt(new \DateTime());
        $this->em->persist($presence);
        $this->em->flush($presence);
    }

    public function invalidate(SessionInterface $session, NodejsSubjectInterface $subject = null)
    {
        $authToken = $this->generateAuthToken($session, $subject);
        $presence = $this->repository->findOneBy(
            array(
                'authToken' => $authToken,
            )
        );
        if ($presence === null) {
            return;
        }
        $this->em->remove($presence);
        $this->em->flush();
    }

    /**
     * @param string $authToken
     * @return \Briareos\NodejsBundle\Entity\NodejsPresence
     */
    public function getPresence($authToken)
    {
        return $this->repository->find($authToken);
    }

    public static function generateAuthToken(SessionInterface $session, NodejsSubjectInterface $subject = null)
    {
        if ($subject !== null) {
            return md5($session->getId() . '-' . $subject->getId() . '-' . $subject->getSalt());
        }

        return md5($session->getId());
    }

    public function runGarbageCollector()
    {
        // @TODO garbage collector
    }
}
