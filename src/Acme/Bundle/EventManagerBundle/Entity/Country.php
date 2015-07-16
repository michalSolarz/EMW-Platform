<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Acme\Bundle\EventManagerBundle\Model\StampedAtEditionEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Country
 * @package Acme\Bundle\EventManagerBundle\Entity
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country implements StampedAtEditionEntityInterface
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
     * @return string
     */
    public function getEditions(){
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
     * @return PaperCategory
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

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
