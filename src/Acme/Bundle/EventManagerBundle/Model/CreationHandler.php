<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 02.08.15
 * Time: 21:40
 */

namespace Acme\Bundle\EventManagerBundle\Model;

use Acme\Bundle\EventManagerBundle\Entity\UserData;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CreationHandler
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorageInterface)
    {
        $this->user = $tokenStorageInterface->getToken()->getUser();
    }

    public function handleCreation(StampedAtCreationInterface $entity)
    {
        $entity->setCreatedBy($this->user);
        $entity->setCreatedAt(new \DateTime('now', new \DateTimeZone('UTC')));

        if ($entity instanceof MappedByUserInterface) {
            $entity->setUser($this->user);
            if ($entity instanceof UserData)
                $this->user->setData($entity);
        }

    }
}