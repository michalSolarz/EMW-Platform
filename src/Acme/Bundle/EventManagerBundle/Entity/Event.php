<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Acme\Bundle\EventManagerBundle\Model\StampedAtCreationInterface;
use Acme\Bundle\EventManagerBundle\Model\StampedAtEditionEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Event
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="Acme\Bundle\EventManagerBundle\EntityRepository\EventRepository")
 */
class Event implements StampedAtCreationInterface, StampedAtEditionEntityInterface
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $createdBy;

    /**
     * @var string
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $editions;


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
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $papersPerParticipant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $eventBeginning;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
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
     *
     * @ORM\OneToMany(targetEntity="EventParticipants", mappedBy="event")
     */
    private $eventParticipants;

    public function __construct()
    {
        $this->papers = new ArrayCollection();
        $this->eventPaperCategories = new ArrayCollection();
    }

    function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @return Event
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
     * @return Event
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getEditions()
    {
        return $this->editions;
    }

    /**
     * @param string $editions
     */
    public function setEditions($editions)
    {
        $this->editions = $editions;
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
     * @return int
     */
    public function getPapersPerParticipant()
    {
        return $this->papersPerParticipant;
    }

    /**
     * @param int $papersPerParticipant
     */
    public function setPapersPerParticipant($papersPerParticipant)
    {
        $this->papersPerParticipant = $papersPerParticipant;
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
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventParticipants()
    {
        return $this->eventParticipants;
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

}