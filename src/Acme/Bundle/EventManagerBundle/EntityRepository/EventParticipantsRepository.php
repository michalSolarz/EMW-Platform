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
            ->select('eventParticipants.createdAt AS joinedAt, user.id AS userId, user.username, user.email, data.name, data.surname, data.gender, data.nationality, data.fieldOfStudies, data.yearOfStudies, data.phoneNumber, data.isVegetarian, data.needsVisa')
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

}