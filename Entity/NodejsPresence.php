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
        $this->setCreatedAt(new \DateTime());
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

    /**
     * @var string $sessionId
     */
    private $sessionId;

    /**
     * @var \DateTime $createdAt
     */
    private $createdAt;


    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return NodejsPresence
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return NodejsPresence
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}