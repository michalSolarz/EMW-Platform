<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 22.09.15
 * Time: 17:13
 */

namespace Acme\Bundle\EventManagerBundle\EntityRepository;


use Acme\Bundle\EventManagerBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function provideUsers($user)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('user.id, user.email, user.username')
            ->from('AcmeEventManagerBundle:User', 'user')
            ->where('user.roles like :roleUser')
            ->andWhere('user != :user')
            ->orderBy('user.id', 'DESC')
            ->setParameter('roleUser', '%"ROLE_USER"%')
            ->setParameter('user', $user)
            ->getQuery();
        return $query->getArrayResult();
    }

    public function provideUsersAndAdmins($user)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('user.id, user.email, user.username')
            ->from('AcmeEventManagerBundle:User', 'user')
            ->where('user.roles like :roleUser')
            ->orWhere('user.roles like :roleAdmin')
            ->andWhere('user != :user')
            ->orderBy('user.id', 'DESC')
            ->setParameter('roleUser', '%"ROLE_USER"%')
            ->setParameter('roleAdmin', '%"ROLE_ADMIN"%')
            ->setParameter('user', $user)
            ->getQuery();
        return $query->getArrayResult();
    }
}