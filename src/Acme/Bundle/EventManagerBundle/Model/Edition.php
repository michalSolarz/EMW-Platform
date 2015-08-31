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
    private $editionAuthor;

    public function __construct(\DateTime $timestamp, EditionAuthor $editionAuthor)
    {
        $this->timestamp = $timestamp;
        $this->editionAuthor = $editionAuthor;
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
    public function getEditionAuthor()
    {
        return $this->editionAuthor;
    }
}