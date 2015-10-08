<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 23.09.15
 * Time: 21:48
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Doctrine\ORM\EntityManager;
use Acme\Bundle\EventManagerBundle\Entity\Event;

class PapersProvider
{
    private $entityManager;
    private $papersRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->papersRepository = $this->entityManager->getRepository('AcmeEventManagerBundle:Paper');
    }

    /**
     * @param Event $event
     * @param $type (a||d||h)
     * @param $period (for a === 0, for d && h !== 0)
     * @param boolean $forPdf
     * @return array
     * @throws \Exception
     */
    public function providePapers(Event $event, $type, $period, $forPdf = false)
    {
        if ($type === 'a') {
            if ($period != 0)
                throw new \Exception('Unknown period from all event.');
            return $this->getAllPapers($event, $forPdf);
        } elseif ($type === 'd') {
            if ($period == 0)
                throw new \Exception('Period cannot be 0');
            return $this->getPapersFromDays($event, $period, $forPdf);
        } elseif ($type === 'h') {
            if ($period == 0)
                throw new \Exception('Period cannot be 0');
            return $this->getPapersFromHours($event, $period, $forPdf);
        } else {
            throw new \Exception('Unknown event papers get type.');
        }
    }

    private function getAllPapers(Event $event, $forPdf = false)
    {
        return $this->papersRepository->getAllPapers($event, $forPdf);
    }

    private function getPapersFromDays(Event $event, $period, $forPdf = false)
    {
        return $this->papersRepository->getPapersFromDaysBefore($event, $period, $forPdf);
    }

    private function getPapersFromHours(Event $event, $period, $forPdf = false)
    {
        return $this->papersRepository->getPapersFromHoursBefore($event, $period, $forPdf);
    }
}