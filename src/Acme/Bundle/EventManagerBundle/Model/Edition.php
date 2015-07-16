<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.07.15
 * Time: 17:11
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Acme\Bundle\EventManagerBundle\Entity\User;

class Edition {
    private $timestamp;
    private $user;

    public function __construct(\DateTime $timestamp, User $user){
        $this->timestamp = $timestamp;
        $this->user = $user;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}