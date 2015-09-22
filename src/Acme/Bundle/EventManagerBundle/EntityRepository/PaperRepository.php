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
            $event->getPapersRegistrationOpening() <= $now &&
            $now <= $event->getPapersRegistrationClosure()
        )
            return true;
        else
            return false;
    }

    public function countParticipantPapers(Event $event, User $user)
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
}