<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 04.07.15
 * Time: 18:06
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Doctrine\ORM\EntityRepository;

class EditionsJsonDeserializer implements EditionsDeserializerInterface
{

    private $editionsStorage;
    private $entityRepository;
    private $jsonString;

    public function __construct(EditionsStorageInterface $editionsStorage, EntityRepository $entityRepository, $jsonString)
    {
        $this->editionsStorage = $editionsStorage;
        $this->entityRepository = $entityRepository;
        $this->jsonString = $jsonString;
    }

    public function deserializeJson()
    {
        $objects = json_decode($this->jsonString);
        if (property_exists($objects, 'editions')) {
            foreach ($objects->editions as $object) {
                $user = $this->entityRepository->findOneBy(array('email' => $object->authorEmail));
                $time = $object->timestamp->time;
                $timeZone = $object->timestamp->timezone->timezone;
                $timestamp = new \DateTime($time, new \DateTimeZone($timeZone));
                $edition = new Edition($timestamp, $user);
                $this->editionsStorage->addNewEdition($edition);
            }
        }
    }

    public function getEditionsStorage(){
        return $this->editionsStorage;
    }
}