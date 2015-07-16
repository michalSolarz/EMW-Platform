<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.07.15
 * Time: 17:37
 */

namespace Acme\Bundle\EventManagerBundle\Model;


interface EditionsStorageInterface {
    public function addNewEdition(Edition $edition);
    public function getStorage();
}