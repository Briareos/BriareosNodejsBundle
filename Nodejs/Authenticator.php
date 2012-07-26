<?php

namespace Briareos\NodejsBundle\Nodejs;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Authenticator
{
    private $em;
    private $repository;
    private $lifetime;

    public function __construct(EntityManager $em, $repositoryName, $lifetime)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($repositoryName);
        $this->lifetime = $lifetime;
    }

    public function authenticate(Session $session, NodejsSubjectInterface $subject = null)
    {
        $presenceClassName = $this->repository->getClassName();
        $authToken = $this->generateAuthToken($session, $subject);
        /** @var $presence \Briareos\NodejsBundle\Entity\NodejsPresence */
        $presence = $this->repository->findOneBy(array(
            'authToken' => $authToken,
        ));
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

    /**
     * @param Session $session
     * @return \Briareos\NodejsBundle\Entity\NodejsPresence
     */
    public function getPresence($authToken)
    {
        return $this->repository->find($authToken);
    }

    public static function generateAuthToken(Session $session, NodejsSubjectInterface $subject = null)
    {
        if ($subject !== null) {
            return md5($session->getId() . '-' . $subject->getId() . '-' . $subject->getSalt());
        }
        return md5($session->getId());
    }

    public function initiateGarbageCollector()
    {
        // @TODO garbage collector
    }
}