<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PaperCategory
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Table(name="paper_category")
 * @ORM\Entity
 */
class PaperCategory
{
    /*
     * Fields
     */
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
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Paper", mappedBy="paperCategory")
     */
    private $papers;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $universalPaperCategory;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventPaperCategories")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $event;

    public function __construct()
    {
        $this->papers = new ArrayCollection();
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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param integer $status
     * @return PaperCategory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
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
     * @return PaperCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUniversalPaperCategory()
    {
        return $this->universalPaperCategory;
    }

    /**
     * @param bool $universalPaperCategory
     * @return PaperCategory
     */
    public function setUniversalPaperCategory($universalPaperCategory)
    {
        $this->universalPaperCategory = $universalPaperCategory;

        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return PaperCategory
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }
}