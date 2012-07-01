<?php

namespace Briareos\NodejsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Briareos\NodejsBundle\Entity\NodejsSubjectInterface;

/**
 * Briareos\ChatBundle\Entity\ChatState
 */
class NodejsPresence
{
    /**
     * @var string $authToken
     */
    private $authToken;

    /**
     * @var \DateTime
     */
    private $seenAt;

    /**
     * @var NodejsSubjectInterface $subject
     */
    private $subject;


    public function __construct()
    {
        $this->setSeenAt(new \DateTime());
    }

    /**
     * @param \DateTime $seenAt
     */
    public function setSeenAt($seenAt)
    {
        $this->seenAt = $seenAt;
    }

    /**
     * @return \DateTime
     */
    public function getSeenAt()
    {
        return $this->seenAt;
    }

    /**
     * @param NodejsSubjectInterface $subject
     */
    public function setSubject(NodejsSubjectInterface $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return NodejsSubjectInterface
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set authToken
     *
     * @param string $authToken
     * @return NodejsPresence
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
        return $this;
    }

    /**
     * Get authToken
     *
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }
}