<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 26.08.15
 * Time: 21:37
 */

namespace Acme\Bundle\EventManagerBundle\Model;


interface MappedByUserInterface
{
    public function setUser($user);

    public function getUser();
}