<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastEditedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $createdBy;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $lastEditedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $registrationOpening;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $registrationClosure;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $eventWithPapers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $papersRegistrationOpening;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $papersRegistrationClosure;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private $eventName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $eventBeginning;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $eventEnd;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $eventIsVisible;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $eventUniqueHash;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PaperCategory", mappedBy="event")
     */
    private $eventPaperCategories;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Paper", mappedBy="event")
     */
    private $papers;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="events")
     */
    private $eventParticipants;

    public function __construct()
    {
        $this->papers = new ArrayCollection();
        $this->eventParticipants = new ArrayCollection();
        $this->eventPaperCategories = new ArrayCollection();
    }

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
     * @param $createdAt
     * @return PaperCategory
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastEditedAt()
    {
        return $this->lastEditedAt;
    }

    /**
     * @param $lastEditedAt
     * @return PaperCategory
     */
    public function setLastEditedAt(\DateTime $lastEditedAt)
    {
        $this->lastEditedAt = $lastEditedAt;

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
     * @return PaperCategory
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return User
     */
    public function getLastEditedBy()
    {
        return $this->lastEditedBy;
    }

    /**
     * @param User $lastEditedBy
     * @return PaperCategory
     */
    public function setLastEditedBy(User $lastEditedBy)
    {
        $this->lastEditedAt = $lastEditedBy;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationOpening()
    {
        return $this->registrationOpening;
    }

    /**
     * @param \DateTime $registrationOpening
     * @return Event
     */
    public function setRegistrationOpening($registrationOpening)
    {
        $this->registrationOpening = $registrationOpening;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationClosure()
    {
        return $this->registrationClosure;
    }

    /**
     * @param \DateTime $registrationClosure
     * @return Event
     */
    public function setRegistrationClosure($registrationClosure)
    {
        $this->registrationClosure = $registrationClosure;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEventWithPapers()
    {
        return $this->eventWithPapers;
    }


    /**
     * @param bool $eventWithPapers
     * @return Event
     */
    public function setEventWithPapers($eventWithPapers)
    {
        $this->eventWithPapers = $eventWithPapers;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPapersRegistrationOpening()
    {
        return $this->papersRegistrationOpening;
    }

    /**
     * @param \DateTime $paperRegistrationOpening
     * @return Event
     */
    public function setPapersRegistrationOpening($paperRegistrationOpening)
    {
        $this->papersRegistrationOpening = $paperRegistrationOpening;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPapersRegistrationClosure()
    {
        return $this->papersRegistrationClosure;
    }

    /**
     * @param \DateTime $paperRegistrationClosure
     * @return Event
     */
    public function setPapersRegistrationClosure($paperRegistrationClosure)
    {
        $this->papersRegistrationClosure = $paperRegistrationClosure;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     * @return Event
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEventBeginning()
    {
        return $this->eventBeginning;
    }

    /**
     * @param \DateTime $eventBeginning
     * @return Event
     */
    public function setEventBeginning($eventBeginning)
    {
        $this->eventBeginning = $eventBeginning;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEventEnd()
    {
        return $this->eventEnd;
    }

    /**
     * @param \DateTime $eventEnd
     * @return Event
     */
    public function setEventEnd($eventEnd)
    {
        $this->eventEnd = $eventEnd;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEventIsVisible()
    {
        return $this->eventIsVisible;
    }

    /**
     * @param bool $eventIsVisible
     * @return Event
     */
    public function setEventIsVisible($eventIsVisible)
    {
        $this->eventIsVisible = $eventIsVisible;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventUniqueHash()
    {
        return $this->eventUniqueHash;
    }

    /**
     * @param string $eventUniqueHash
     * @return Event
     */
    public function setEventUniqueHash($eventUniqueHash)
    {
        $this->eventUniqueHash = $eventUniqueHash;

        return $this;
    }

    /**
     * @param ArrayCollection $eventParticipants
     *
     * @return Event
     */
    public function setEventParticipants($eventParticipants)
    {
        $this->eventParticipants = $eventParticipants;

        return $this;
    }

    /**
     * Add users
     *
     * @param User $user
     * @return Event
     */
    public function addEventParticipant(User $user)
    {
        if (!$this->eventParticipants->contains($user)) {
            $this->eventParticipants[] = $user;
            $user->addEvent($this);
        }

        return $this;
    }

    /**
     * Remove users
     *
     * @param User $user
     */
    public function removeEventParticipant(User $user)
    {
        $this->eventParticipants->removeElement($user);
        $user->removeEvent($this);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventParticipant()
    {
        return $this->eventParticipants;
    }
}