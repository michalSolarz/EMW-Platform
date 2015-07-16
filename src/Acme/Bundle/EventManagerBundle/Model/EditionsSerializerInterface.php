<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.07.15
 * Time: 17:41
 */

namespace Acme\Bundle\EventManagerBundle\Model;


interface EditionsSerializerInterface
{
    public function __construct(EditionsStorageInterface $editionsStorage);
}