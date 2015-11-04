<?php

namespace Acme\Bundle\EventManagerBundle\Entity;

use Acme\Bundle\EventManagerBundle\Model\MappedByUserInterface;
use Acme\Bundle\EventManagerBundle\Model\StampedAtCreationInterface;
use Acme\Bundle\EventManagerBundle\Model\StampedAtEditionEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserData
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="user_data")
 * @ORM\Entity
 */
class UserData implements StampedAtCreationInterface, StampedAtEditionEntityInterface, MappedByUserInterface
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $surname;

    /**
     * @ORM\Column(type="string")
     */
    private $gender;
    /**
     * @ORM\Column(type="string")
     */
    private $nationality;
    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $country;
    /**
     * @var University
     *
     * @ORM\ManyToOne(targetEntity="University")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $university;
    /**
     * @var Faculty
     *
     * @ORM\ManyToOne(targetEntity="Faculty")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $faculty;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldOfStudies;
    /**
     * @ORM\Column(type="string")
     */
    private $yearOfStudies;
    /**
     * @ORM\Column(type="string")
     */
    private $phoneNumber;
    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $isVegetarian;
    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $needsVisa;
    /**
     * @ORM\Column(type="boolean")
     */
    private $acceptedTerms;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $photoUniqueId;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passportUniqueId;
    /**
     * @ORM\OneToOne(targetEntity="User", mappedBy="data")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserData
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return UserData
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     * @return UserData
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get fieldOfStudies
     *
     * @return string
     */
    public function getFieldOfStudies()
    {
        return $this->fieldOfStudies;
    }

    /**
     * Set fieldOfStudies
     *
     * @param string $fieldOfStudies
     * @return UserData
     */
    public function setFieldOfStudies($fieldOfStudies)
    {
        $this->fieldOfStudies = $fieldOfStudies;

        return $this;
    }

    /**
     * Get yearOfStudies
     *
     * @return string
     */
    public function getYearOfStudies()
    {
        return $this->yearOfStudies;
    }

    /**
     * Set yearOfStudies
     *
     * @param string $yearOfStudies
     * @return UserData
     */
    public function setYearOfStudies($yearOfStudies)
    {
        $this->yearOfStudies = $yearOfStudies;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return UserData
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get isVegetarian
     *
     * @return boolean
     */
    public function getIsVegetarian()
    {
        return $this->isVegetarian;
    }

    /**
     * Set isVegetarian
     *
     * @param boolean $isVegetarian
     * @return UserData
     */
    public function setIsVegetarian($isVegetarian)
    {
        $this->isVegetarian = $isVegetarian;

        return $this;
    }

    /**
     * Get needsVisa
     *
     * @return string
     */
    public function getNeedsVisa()
    {
        return $this->needsVisa;
    }

    /**
     * Set needsVisa
     *
     * @param string $needsVisa
     * @return UserData
     */
    public function setNeedsVisa($needsVisa)
    {
        $this->needsVisa = $needsVisa;

        return $this;
    }

    /**
     * Get acceptedTerms
     *
     * @return string
     */
    public function getAcceptedTerms()
    {
        return $this->acceptedTerms;
    }

    /**
     * Set acceptedTerms
     *
     * @param string $acceptedTerms
     * @return UserData
     */
    public function setAcceptedTerms($acceptedTerms)
    {
        $this->acceptedTerms = $acceptedTerms;

        return $this;
    }

    /**
     * Get photoUniqueId
     *
     * @return integer
     */
    public function getPhotoUniqueId()
    {
        return $this->photoUniqueId;
    }

    /**
     * Set photoUniqueId
     *
     * @param integer $photoUniqueId
     * @return UserData
     */
    public function setPhotoUniqueId($photoUniqueId)
    {
        $this->photoUniqueId = $photoUniqueId;

        return $this;
    }

    /**
     * Get passportUniqueId
     *
     * @return integer
     */
    public function getPassportUniqueId()
    {
        return $this->passportUniqueId;
    }

    /**
     * Set passportUniqueId
     *
     * @param integer $passportUniqueId
     * @return UserData
     */
    public function setPassportUniqueId($passportUniqueId)
    {
        $this->passportUniqueId = $passportUniqueId;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return UserData
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdBy
     *
     * @param User $createdBy
     * @return UserData
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param Country $country
     * @return UserData
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get university
     *
     * @return University
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * Set university
     *
     * @param University $university
     * @return UserData
     */
    public function setUniversity(University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get faculty
     *
     * @return Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set faculty
     *
     * @param Faculty $faculty
     * @return UserData
     */
    public function setFaculty(Faculty $faculty = null)
    {
        $this->faculty = $faculty;

        return $this;
    }
}
