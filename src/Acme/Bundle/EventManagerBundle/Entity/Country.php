<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Country
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;


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
    public function getLastEditedAt()
    {
        return $this->lastEditedAt;
    }

    /**
     * @param \DateTime $lastEditedAt
     * @return PaperCategory
     */
    public function setLastEditedAt(\DateTime $lastEditedAt)
    {
        $this->lastEditedAt = $lastEditedAt;

        return $this;
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
}
