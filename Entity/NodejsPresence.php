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
     * @var integer $id
     */
    private $id;

    /**
     * @var string $action
     */
    private $action;

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
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

}