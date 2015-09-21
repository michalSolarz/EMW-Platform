<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 13.09.15
 * Time: 13:40
 */

namespace Acme\Bundle\EventManagerBundle\EntityRepository;


use Acme\Bundle\EventManagerBundle\Entity\Event;
use Acme\Bundle\EventManagerBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class EventParticipantsRepository
 * @package Acme\Bundle\EventManagerBundle\EntityRepository
 */
class EventParticipantsRepository extends EntityRepository
{
    /**
     * @param Event $event
     * @param User $user
     * @return bool
     */
    public function isParticipant(Event $event, User $user)
    {
        $repository = $this->getEntityManager()->getRepository('AcmeEventManagerBundle:EventParticipants');
        $data = $repository->findOneBy(array('event' => $event, 'user' => $user));
        if ($data === null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param Event $event
     * @param $daysAmount
     * @return array
     */
    public function getParticipantsFromDaysBefore(Event $event, $daysAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $joinedAfter = $now->modify('-' . $daysAmount . ' day');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('eventParticipants.createdAt AS joinedAt, user.id AS userId, user.username, user.email, data.name, data.surname')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->leftJoin('eventParticipants.user', 'user')
            ->leftJoin('user.data', 'data')
            ->where('eventParticipants.createdAt >= :joinedAfter')
            ->andWhere('eventParticipants.event = :event')
            ->setParameters(array(
                    'joinedAfter' => $joinedAfter,
                    'event' => $event
                )
            )
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param Event $event
     * @param $daysAmount
     * @return string
     */
    public function countParticipantsFromDaysBefore(Event $event, $daysAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $joinedAfter = $now->modify('-' . $daysAmount . ' day');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('substring(eventParticipants.createdAt, 1, 10) as date', 'count(eventParticipants.id) as number')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->where('eventParticipants.event = :event')
            ->andWhere('eventParticipants.createdAt >= :joinedAfter')
            ->orderBy('date', 'ASC')
            ->groupBy('date')
            ->setParameters(array(
                'event' => $event,
                'joinedAfter' => $joinedAfter,
            ))
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param Event $event
     * @param $hoursAmount
     * @return array
     */
    public function getParticipantsFromHoursBefore(Event $event, $hoursAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $joinedAfter = $now->modify('-' . $hoursAmount . ' hour');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('eventParticipants.createdAt AS joinedAt, user.id AS userId, user.username, user.email, data.name, data.surname')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->leftJoin('eventParticipants.user', 'user')
            ->leftJoin('user.data', 'data')
            ->where('eventParticipants.createdAt >= :joinedAfter')
            ->andWhere('eventParticipants.event = :event')
            ->setParameters(array(
                    'joinedAfter' => $joinedAfter,
                    'event' => $event
                )
            )
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param Event $event
     * @param $hoursAmount
     * @return string
     */
    public function countParticipantsFromHoursBefore(Event $event, $hoursAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $joinedAfter = $now->modify('-' . $hoursAmount . ' hour');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('substring(eventParticipants.createdAt, 1, 13) as date', 'count(eventParticipants.id) as number')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->where('eventParticipants.event = :event')
            ->andWhere('eventParticipants.createdAt >= :joinedAfter')
            ->orderBy('date', 'ASC')
            ->groupBy('date')
            ->setParameters(array(
                'event' => $event,
                'joinedAfter' => $joinedAfter,
            ))
            ->getQuery();

        return $query->getArrayResult();
    }


    /**
     * @param Event $event
     * @return array
     */
    public function getAllParticipants(Event $event)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('eventParticipants.createdAt AS joinedAt, user.id AS userId, user.username, user.email, data.name, data.surname')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->where('eventParticipants.event = :event')
            ->leftJoin('eventParticipants.user', 'user')
            ->leftJoin('user.data', 'data')
            ->setParameter('event', $event)
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param Event $event
     * @return string
     */
    public function countAllParticipants(Event $event)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('count(eventParticipants)')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->where('eventParticipants.event = :event')
            ->setParameter('event', $event)
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getGrouped(Event $event)
    {
//        $query = $this->getEntityManager()->createQueryBuilder()
//            ->select('eventParticipants,
//            substring(eventParticipants.createdAt, 1, 10) as day, substring(eventParticipants.createdAt, 1, 7) as month')
//            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
//            ->where('eventParticipants.event = :event')
//            ->leftJoin('eventParticipants.user', 'user')
//            ->leftJoin('user.data', 'data')
//            ->groupBy('month')
//            ->setParameter('event', $event)
//            ->getQuery();
        $query = $this->getEntityManager()->createQuery('SELECT p.createdAt, SUBSTRING(p.createdAt, 9, 2) as month
FROM AcmeEventManagerBundle:EventParticipants p
GROUP BY month
');

//        $query = $this->getEntityManager()->createQuery('SELECT p, SUBSTRING(p.createdAt, 6, 2) as month FROM AcmeEventManagerBundle:EventParticipants p GROUP BY month');
        return $query->getResult();
    }

    public function test(Event $event, $hoursAmount)
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $joinedAfter = $now->modify('-' . $hoursAmount . ' hour');
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('substring(eventParticipants.createdAt, 1, 13) as date', 'count(eventParticipants.id) as number')
            ->from('AcmeEventManagerBundle:EventParticipants', 'eventParticipants')
            ->where('eventParticipants.event = :event')
            ->andWhere('eventParticipants.createdAt >= :j')
            ->orderBy('date', 'DESC')
            ->groupBy('date')
            ->setParameters(array(
                'event' => $event,
                'j' => $joinedAfter,
            ))
            ->getQuery();

        return $query->getResult();

    }

    private function rewriteArray($array)
    {
        $results = array();
        foreach ($array as $item) {
            $results[$item['date']] = array('joined' => $item['number']);
        }
        return $results;
    }
}