<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 19.08.15
 * Time: 18:08
 */

namespace Acme\Bundle\EventManagerBundle\Util;


use Acme\Bundle\EventManagerBundle\Entity\Country;
use Acme\Bundle\EventManagerBundle\Entity\Faculty;
use Acme\Bundle\EventManagerBundle\Entity\University;
use Acme\Bundle\EventManagerBundle\Model\CreationHandler;
use Doctrine\ORM\EntityManager;

class CSVImportHandler
{
    private $entityManager;
    private $creationHandler;

    public function __construct(EntityManager $entityManager, CreationHandler $creationHandler)
    {
        $this->entityManager = $entityManager;
        $this->creationHandler = $creationHandler;
    }

    public function importCountryList(array $countryList)
    {
        foreach ($countryList as $country) {
            $countryEntity = new Country();
            $countryEntity->setName($country[0]);
            $this->creationHandler->handleCreation($countryEntity);
            $this->entityManager->persist($countryEntity);
        }
        $this->entityManager->flush();
    }

    public function importFacultyList(array $facultyList)
    {
        foreach ($facultyList as $faculty) {
            if (!$this->entityManager->getRepository('AcmeEventManagerBundle:Faculty')->findOneBy(array('name' => $faculty[0]))) {
                $facultyEntity = new Faculty();
                $facultyEntity->setName($faculty[0]);
                $this->creationHandler->handleCreation($facultyEntity);
                $this->entityManager->persist($facultyEntity);
            }
        }
        $this->entityManager->flush();
    }

    public function importUniversityList(array $universityList)
    {
        foreach ($universityList as $university) {
            if (!$this->entityManager->getRepository('AcmeEventManagerBundle:University')->findOneBy(array('name' => $university[0]))) {
                $universityEntity = new University();

                $universityEntity->setName($university[0]);
                $universityEntity->setAddress($university[1]);

                $this->creationHandler->handleCreation($universityEntity);
                $this->entityManager->persist($universityEntity);
            }
        }
        $this->entityManager->flush();
    }
}