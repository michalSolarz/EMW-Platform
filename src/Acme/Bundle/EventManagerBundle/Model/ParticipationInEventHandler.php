<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 10.09.15
 * Time: 15:15
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\Event;
use Acme\Bundle\EventManagerBundle\Entity\EventParticipants;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ParticipationInEventHandler
{
    private $entityManager;
    private $creationHandler;
    private $eventParticipantsRepository;
    private $user;

    function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, CreationHandler $creationHandler)
    {
        $this->entityManager = $entityManager;
        $this->eventParticipantsRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:EventParticipants');
        $this->user = $tokenStorage->getToken()->getUser();
        $this->creationHandler = $creationHandler;
    }

    public function joinEvent(Event $eventEntity)
    {
        if ($this->eventParticipantsRepository->isParticipant($eventEntity, $this->user))
            return false;

        if ($eventEntity->getRegistrationOpening() <= new \DateTime('now', new \DateTimeZone('UTC')) &&
            new \DateTime('now', new \DateTimeZone('UTC')) <= $eventEntity->getPapersRegistrationClosure()
        ) {
            $eventParticipant = new EventParticipants();
            $eventParticipant->setEvent($eventEntity)
                ->setUser($this->user);
            $this->creationHandler->handleCreation($eventParticipant);
            $this->entityManager->persist($eventParticipant);
            $this->entityManager->flush();
            return true;
        }
    }

    public function leaveEvent(Event $eventEntity)
    {
        if (!$this->eventParticipantsRepository->isParticipant($eventEntity, $this->user))
            return false;

        if ($eventEntity->getRegistrationOpening() <= new \DateTime('now', new \DateTimeZone('UTC')) &&
            new \DateTime('now', new \DateTimeZone('UTC')) <= $eventEntity->getPapersRegistrationClosure()
        ) {
            $eventParticipant = $this->eventParticipantsRepository->findOneBy(array('event' => $eventEntity, 'user' => $this->user));
            $this->entityManager->remove($eventParticipant);
            $this->entityManager->flush();
            return true;
        }
    }
}