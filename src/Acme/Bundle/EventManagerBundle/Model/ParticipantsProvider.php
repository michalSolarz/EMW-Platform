<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 18.09.15
 * Time: 13:14
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\Event;
use Doctrine\ORM\EntityManager;

class ParticipantsProvider
{
    private $entityManager;
    private $eventParticipantsRepository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventParticipantsRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:EventParticipants');
    }

    /**
     * @param Event $event
     * @param $type (a||d||h)
     * @param $period (for a === 0, for d && h !== 0)
     * @return array
     * @throws \Exception
     */
    public function provideParticipants(Event $event, $type, $period)
    {
        if ($type === 'a') {
            if ($period != 0)
                throw new \Exception('Unknown period from all event.');
            return $this->getAllParticipants($event);
        } elseif ($type === 'd') {
            if ($period == 0)
                throw new \Exception('Period cannot be 0');
            return $this->getParticipantsFromDays($event, $period);
        } elseif ($type === 'h') {
            if ($period == 0)
                throw new \Exception('Period cannot be 0');
            return $this->getParticipantsFromHours($event, $period);
        } else {
            throw new \Exception('Unknown event participants get type.');
        }
    }

    /**
     * @param Event $event
     * @return mixed
     */
    private function getAllParticipants(Event $event)
    {
        return $this->eventParticipantsRepository->getAllParticipants($event);
    }


    /**
     * @param Event $event
     * @param $period
     * @return array
     */
    private function getParticipantsFromDays(Event $event, $period)
    {
        return $this->eventParticipantsRepository->getParticipantsFromDaysBefore($event, $period);
    }

    /**
     * @param Event $event
     * @param $period
     * @return array
     */
    private function getParticipantsFromHours(Event $event, $period)
    {
        return $this->eventParticipantsRepository->getParticipantsFromHoursBefore($event, $period);
    }
}