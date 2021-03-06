<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 16.09.15
 * Time: 18:28
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\Event;
use Doctrine\ORM\EntityManager;

class EventStatisticProvider
{
    private $entityManager;
    private $eventParticipantsRepository;
    private $paperRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventParticipantsRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:EventParticipants');
        $this->paperRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:Paper');
    }

    public function getFullStatistics(Event $event)
    {
        return array(
            'participants' => array(
                'last12Hours' => $this->countSubSumOfParticipants($this->eventParticipantsRepository->countParticipantsFromHoursBefore($event, 12)),
                'last31Days' => $this->countSubSumOfParticipants($this->eventParticipantsRepository->countParticipantsFromDaysBefore($event, 31)),
                'totalAmount' => $this->eventParticipantsRepository->countAllParticipants($event),),
            'papers' => array(
                'last12Hours' => $this->countSubSumOfParticipants($this->paperRepository->countPapersFromHoursBefore($event, 12)),
                'last31Days' => $this->countSubSumOfParticipants($this->paperRepository->countPapersFromDaysBefore($event, 31)),
                'totalAmount' => $this->paperRepository->countAllPapers($event),
            ),
        );
    }

    private function countSubSumOfParticipants($statistics)
    {
        if (!empty($statistics)) {
            $subSum = 0;
            $results = array();
            foreach ($statistics as $item) {
                $subSum += $item['number'];
                $results[$item['date']] = array('number' => $item['number'], 'subSum' => $subSum);
            }
            return array_reverse($results);
        } else
            return false;
    }
}