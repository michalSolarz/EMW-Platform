<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 25.08.15
 * Time: 14:09
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UniversitiesDataTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
        var_dump($facultyString);
        // no issue number? It's optional, so that's ok
        if (!$facultyString) {
            return null;
        }

        $country = $this->entityManager
            ->getRepository('AcmeEventManagerBundle:University')
            // query for the issue with this id
            ->find(1);

        if (null === $country) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $facultyString
            ));
        }

        return $country;
    }
}