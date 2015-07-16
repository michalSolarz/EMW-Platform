<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 04.07.15
 * Time: 20:15
 */

namespace Acme\Bundle\EventManagerBundle\Model;


interface StampedAtEditionEntityInterface
{
    public function getEditions();

    public function setEditions($editions);
}