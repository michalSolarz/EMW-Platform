<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 25.08.15
 * Time: 14:09
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\University;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class UniversityDataTransformer implements DataTransformerInterface
{
    private $entityManager;
    private $creationHandler;

    public function __construct(EntityManager $entityManager, CreationHandler $creationHandler)
    {
        $this->entityManager = $entityManager;
        $this->creationHandler = $creationHandler;
    }

    public function transform($country)
    {
        if ($country == null)
            return null;

        return array('name' => $country->getName(), 'address' => $country->getAddress());
    }

    public function reverseTransform($universityString)
    {
        if ($universityString === null || $universityString === '')
            return null;

        $universityEntity = $this->entityManager->getRepository('AcmeEventManagerBundle:University')->findOneBy(array(
            'name' => $universityString['name']));

        if ($universityEntity === null) {
            $universityEntity = new University();
            $universityEntity->setName($universityString['name']);
            $universityEntity->setAddress($universityString['address']);
            $this->creationHandler->handleCreation($universityEntity);
            $this->entityManager->persist($universityEntity);
        }

        return $universityEntity;
    }
}