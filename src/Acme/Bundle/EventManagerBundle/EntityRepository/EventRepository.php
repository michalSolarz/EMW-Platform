<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 31.08.15
 * Time: 21:12
 */

namespace Acme\Bundle\EventManagerBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function getAllEventsWithParticipantsNumber()
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('event.id, event.name, event.eventBeginning, event.eventEnd, event.registrationOpening, event.registrationClosure, event.papersRegistrationOpening , event.papersRegistrationClosure ')
            ->from('AcmeEventManagerBundle:Event', 'event')
            ->leftJoin('event.eventParticipants', 'eventParticipants')
            ->addSelect('count(eventParticipants) AS eventParticipantsCount')
            ->groupBy('event.id')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function getActiveAndVisibleEvents()
    {
        $query = $this->getEntityManager()->createQueryBuilder()->select('events')
            ->from('AcmeEventManagerBundle:Event', 'events')
            ->where('events.eventEnd >= :now')
            ->andWhere('events.eventIsVisible = :visible')
            ->setParameters(array(
                    'now' => new \DateTime('now', new \DateTimeZone('UTC')),
                    'visible' => true
                )
            )
            ->getQuery();

        return $query->execute();
    }

    public function getPastEvents()
    {
        $query = $this->getEntityManager()->createQueryBuilder()->select('events')
            ->from('AcmeEventManagerBundle:Event', 'events')
            ->where('events.eventEnd <= :now')
            ->andWhere('events.eventIsVisible = :visible')
            ->setParameters(array(
                    'now' => new \DateTime('now', new \DateTimeZone('UTC')),
                    'visible' => true
                )
            )
            ->getQuery();

        return $query->execute();
    }
}