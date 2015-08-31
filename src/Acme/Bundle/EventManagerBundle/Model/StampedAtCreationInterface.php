<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.07.15
 * Time: 16:51
 */

namespace Acme\Bundle\EventManagerBundle\Model;

use Acme\Bundle\EventManagerBundle\Entity\User;


interface StampedAtCreationInterface
{
    public function setCreatedAt(\DateTime $createdAt);

    public function setCreatedBy(User $createdBy);

    public function getCreatedAt();

    public function getCreatedBy();
}