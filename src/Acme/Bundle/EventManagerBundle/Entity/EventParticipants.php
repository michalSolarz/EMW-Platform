<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 11.09.15
 * Time: 11:34
 */

namespace Acme\Bundle\EventManagerBundle\Entity;

use Acme\Bundle\EventManagerBundle\Model\StampedAtCreationInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Acme\Bundle\EventManagerBundle\EntityRepository\EventParticipantsRepository")
 * @ORM\Table(name="event_participants")
 */
class EventParticipants implements StampedAtCreationInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventParticipants")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     */
    protected $event;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="eventParticipants")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $createdBy;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return $this
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return EventParticipants
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return EventParticipants
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }


}