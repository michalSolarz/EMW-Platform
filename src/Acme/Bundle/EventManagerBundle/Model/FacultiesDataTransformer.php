<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 25.08.15
 * Time: 14:09
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\Faculty;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class FacultiesDataTransformer implements DataTransformerInterface
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
        if (null === $country) {
            return '';
        }
        return $country->getName();
    }

    public function reverseTransform($facultyString)
    {
        // no issue number? It's optional, so that's ok
        if (!$facultyString) {
            return null;
        }

        $faculty = $this->entityManager
            ->getRepository('AcmeEventManagerBundle:Faculty')
            // query for the issue with this id
            ->findOneBy(array('name' => $facultyString));

        if ($faculty === null) {
            $facultyEntity = new Faculty();
            $facultyEntity->setName($facultyString);
            $this->creationHandler->handleCreation($facultyEntity);
            $this->entityManager->persist($facultyEntity);
        }

        return $faculty;
    }
}