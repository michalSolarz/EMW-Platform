<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 22.09.15
 * Time: 20:19
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Doctrine\ORM\EntityManager;
use Acme\Bundle\EventManagerBundle\Entity\Paper;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PaperAdditionHandler
{
    private $entityManager;
    private $creationHandler;
    private $participationHandler;
    private $eventRepository;
    private $eventParticipantsRepository;
    private $paperRepository;
    private $user;


    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, CreationHandler $creationHandler, ParticipationInEventHandler $participationInEventHandler)
    {
        $this->entityManager = $entityManager;
        $this->creationHandler = $creationHandler;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->participationHandler = $participationInEventHandler;
        $this->eventRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:Event');
        $this->eventParticipantsRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:EventParticipants');
        $this->paperRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:Paper');
    }

    public function handleAddition(Paper $paper, $eventId)
    {
        $eventEntity = $this->eventRepository->find($eventId);

        if (!$eventEntity)
            throw $this->createNotFoundException('Unable to find Event entity.');

        if (!$this->paperRepository->isPossibleToAddPaper($eventEntity, $this->user))
            return false;


        if (!$this->eventParticipantsRepository->isParticipant($eventEntity, $this->user))
            $this->participationHandler->joinEvent($eventEntity);

        $this->creationHandler->handleCreation($paper);
        $paper->setEvent($eventEntity);
        $paper->setStatus(0);

        return $eventEntity;
    }
}