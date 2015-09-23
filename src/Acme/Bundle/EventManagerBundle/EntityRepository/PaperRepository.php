<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 22.09.15
 * Time: 17:13
 */

namespace Acme\Bundle\EventManagerBundle\EntityRepository;


use Acme\Bundle\EventManagerBundle\Entity\Event;
use Acme\Bundle\EventManagerBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class PaperRepository extends EntityRepository
{
    public function isPossibleToAddPaper(Event $event, User $user)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        if ($this->countParticipantPapers($event, $user) < $event->getPapersPerParticipant() &&
            $event->getEventWithPapers() &&
            $event->getPapersRegistrationOpening() <= $now &&
            $now <= $event->getPapersRegistrationClosure()
        )
            return true;
        else
            return false;
    }

    private function countParticipantPapers(Event $event, User $user)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('count(papers)')
            ->from('AcmeEventManagerBundle:Paper', 'papers')
            ->where('papers.event = :event')
            ->andWhere('papers.createdBy = :user')
            ->setParameters(array(
                'event' => $event,
                'user' => $user,
            ))
            ->getQuery();
        return $query->getSingleScalarResult();
    }

    public function countPapersFromHoursBefore(Event $event, $hoursAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $addedAfter = $now->modify('-' . $hoursAmount . ' hour');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('substring(papers.createdAt, 1, 13) as date', 'count(papers.id) as number')
            ->from('AcmeEventManagerBundle:Paper', 'papers')
            ->where('papers.event = :event')
            ->andWhere('papers.createdAt >= :addedAfter')
            ->setParameters(array(
                'event' => $event,
                'addedAfter' => $addedAfter,
            ))
            ->groupBy('date')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function getPapersFromHoursBefore(Event $event, $hoursAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $addedAfter = $now->modify('-' . $hoursAmount . ' day');
    }

    public function countPapersFromDaysBefore(Event $event, $daysAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $addedAfter = $now->modify('-' . $daysAmount . ' day');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('substring(papers.createdAt, 1, 10) as date', 'count(papers.id) as number')
            ->from('AcmeEventManagerBundle:Paper', 'papers')
            ->where('papers.event = :event')
            ->andWhere('papers.createdAt >= :addedAfter')
            ->setParameters(array(
                'event' => $event,
                'addedAfter' => $addedAfter,
            ))
            ->groupBy('date')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function countAllPapers(Event $event)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('count(papers)')
            ->from('AcmeEventManagerBundle:Paper', 'papers')
            ->where('papers.event = :event')
            ->setParameter('event', $event)
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getPapersFromDaysBefore(Event $event, $daysAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $addedAfter = $now->modify('-' . $daysAmount . ' day');
    }
}