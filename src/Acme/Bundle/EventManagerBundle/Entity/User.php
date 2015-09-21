<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="EventParticipants", mappedBy="user")
     */
    private $eventParticipants;

    /**
     * @ORM\OneToOne(targetEntity="UserData", inversedBy="user")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $data;


    public function __construct()
    {
        parent::__construct();
        $this->events = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add event
     *
     * @param Event $event
     * @return User
     */
    public function addEvent(Event $event)
    {
        if ($this->eventParticipants->contains($event)) {
            return;
        }
        $this->eventParticipants->add($event);
        $event->addEventParticipant($this);
    }

    /**
     * Remove event
     *
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        if (!$this->events->contains($event)) {
            return;
        }
        $this->events->removeElement($event);
        $event->removeEventParticipant($this);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvent()
    {
        return $this->events;
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection $events
     *
     * @return User
     */
    public function setEvents($events)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get data
     *
     * @return UserData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data
     *
     * @param UserData $data
     * @return User
     */
    public function setData(UserData $data = null)
    {
        $this->data = $data;

        return $this;
    }
}
