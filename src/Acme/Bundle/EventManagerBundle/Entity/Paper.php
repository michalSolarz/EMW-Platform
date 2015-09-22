<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Acme\Bundle\EventManagerBundle\Model\StampedAtCreationInterface;
use Acme\Bundle\EventManagerBundle\Model\StampedAtEditionEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Paper
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Table(name="paper")
 * @ORM\Entity(repositoryClass="Acme\Bundle\EventManagerBundle\EntityRepository\PaperRepository")
 */
class Paper implements StampedAtCreationInterface, StampedAtEditionEntityInterface
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
     * @var string
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $editions;


    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $createdBy;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coAuthors;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $researchAdvisor;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="PaperCategory", inversedBy="papers")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $paperCategory;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="papers")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $event;


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
     * @return Paper
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return Paper
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

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
     * @param $status
     * @return Paper
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return Paper
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getCoAuthors()
    {
        return $this->coAuthors;
    }

    /**
     * @param $coAuthors
     * @return Paper
     */
    public function setCoAuthors($coAuthors)
    {
        $this->coAuthors = $coAuthors;

        return $this;
    }

    /**
     * @return string
     */
    public function getResearchAdvisor()
    {
        return $this->researchAdvisor;
    }

    /**
     * @param $researchAdvisor
     * @return Paper
     */
    public function setResearchAdvisor($researchAdvisor)
    {
        $this->researchAdvisor = $researchAdvisor;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return Paper
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return PaperCategory
     */
    public function getPaperCategory()
    {
        return $this->paperCategory;
    }

    /**
     * @param PaperCategory $paperCategory
     * @return Paper
     */
    public function setPaperCategory(PaperCategory $paperCategory)
    {
        $this->paperCategory = $paperCategory;

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
     * @return Paper
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }
}