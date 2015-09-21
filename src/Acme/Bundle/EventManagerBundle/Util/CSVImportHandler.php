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
        $repo = $this->entityManager->getRepository('AcmeEventManagerBundle:Country');
        foreach ($countryList as $country) {
            if (!$repo->findOneBy(array('name' => $country[0]))) {
                $countryEntity = new Country();
                $countryEntity->setName($country[0]);
                $this->creationHandler->handleCreation($countryEntity);
                $this->entityManager->persist($countryEntity);
            }
        }
        $this->entityManager->flush();
        return true;
    }

    public function importFacultyList(array $facultyList)
    {
        $repo = $this->entityManager->getRepository('AcmeEventManagerBundle:Faculty');
        foreach ($facultyList as $faculty) {
            if (!$repo->findOneBy(array('name' => $faculty[0]))) {
                $facultyEntity = new Faculty();
                $facultyEntity->setName($faculty[0]);
                $this->creationHandler->handleCreation($facultyEntity);
                $this->entityManager->persist($facultyEntity);
            }
        }
        $this->entityManager->flush();
        return true;
    }

    public function importUniversityList(array $universityList)
    {
        $repo = $this->entityManager->getRepository('AcmeEventManagerBundle:University');
        foreach ($universityList as $university) {
            if (!$repo->findOneBy(array('name' => $university[0]))) {
                $universityEntity = new University();

                $universityEntity->setName($university[0]);
                $universityEntity->setAddress($university[1]);

                $this->creationHandler->handleCreation($universityEntity);
                $this->entityManager->persist($universityEntity);
            }
        }
        $this->entityManager->flush();
        return true;
    }
}