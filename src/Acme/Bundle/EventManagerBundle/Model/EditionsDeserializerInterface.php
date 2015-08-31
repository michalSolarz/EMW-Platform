<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 04.07.15
 * Time: 17:47
 */

namespace Acme\Bundle\EventManagerBundle\Model;


interface EditionsDeserializerInterface
{
    public function __construct(EditionsStorageInterface $editionsStorage, $data);
}