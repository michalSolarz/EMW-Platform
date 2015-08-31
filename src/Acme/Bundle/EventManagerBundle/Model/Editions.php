<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.07.15
 * Time: 17:12
 */

namespace Acme\Bundle\EventManagerBundle\Model;


class Editions implements EditionsStorageInterface {
    private $editionsContainer;

    public function __construct(\SplObjectStorage $editionsContainer = null)
    {
        if ($editionsContainer) {
            $this->editionsContainer = $editionsContainer;
        } else {
            $this->editionsContainer = new \SplObjectStorage();
        }
    }

    public function addNewEdition(Edition $edition){
        $this->editionsContainer->attach($edition);
    }

    public function getStorage(){
        return $this->editionsContainer;
    }
}