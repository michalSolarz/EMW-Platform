<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 25.08.15
 * Time: 14:09
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\Faculty;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class FacultiesDataTransformer implements DataTransformerInterface
{
    private $entityManager;
    private $creationHandler;

    public function __construct(ObjectManager $entityManager, CreationHandler $creationHandler)
    {
        $this->entityManager = $entityManager;
        $this->creationHandler = $creationHandler;
    }

    public function transform($faculty)
    {
        if ($faculty == null)
            return null;

        return array('name' => $faculty->getName());
    }

    public function reverseTransform($facultyString)
    {
        if ($facultyString === null || $facultyString === '')
            return null;

        $facultyEntity = $this->entityManager->getRepository('AcmeEventManagerBundle:Faculty')->findOneBy(array(
            'name' => $facultyString['name']));

        if ($facultyEntity === null) {
            $facultyEntity = new Faculty();
            $facultyEntity->setName($facultyString['name']);
            $this->creationHandler->handleCreation($facultyEntity);
            $this->entityManager->persist($facultyEntity);
        }

        return $facultyEntity;
    }
}