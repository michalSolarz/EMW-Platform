<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 04.07.15
 * Time: 20:13
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditionHandler
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorageInterface)
    {
        $this->user = $tokenStorageInterface->getToken()->getUser();
    }

    public function handleEdition(StampedAtEditionEntityInterface $entity)
    {
        $pastEditions = $entity->getEditions();
        $editionsStorage = new Editions();
        $deserializer = new EditionsJsonDeserializer($editionsStorage, $pastEditions);
        $deserializer->deserializeJson();
        $editionAuthor = new EditionAuthor($this->user->getId(), $this->user->getEmail());
        $edition = new Edition(new \DateTime('now', new \DateTimeZone('UTC')), $editionAuthor);
        $editionsStorage->addNewEdition($edition);
        $jsonSerializer = new EditionsJsonSerializer($editionsStorage);
        $entity->setEditions($jsonSerializer->getJsonStringFromStorage());
    }
}