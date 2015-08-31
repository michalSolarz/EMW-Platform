<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 04.07.15
 * Time: 18:06
 */

namespace Acme\Bundle\EventManagerBundle\Model;


class EditionsJsonDeserializer implements EditionsDeserializerInterface
{

    private $editionsStorage;
    private $jsonString;

    public function __construct(EditionsStorageInterface $editionsStorage, $jsonString)
    {
        $this->editionsStorage = $editionsStorage;
        $this->jsonString = $jsonString;
        if (!$this->jsonString) {
            $this->jsonString = '{}';
        }
    }

    public function deserializeJson()
    {
        $objects = json_decode($this->jsonString);
        if (property_exists($objects, 'editions')) {
            foreach ($objects->editions as $object) {
                $time = $object->timestamp->time;
                $timeZone = $object->timestamp->timezone->timezone;
                $timestamp = new \DateTime($time, new \DateTimeZone($timeZone));
                $editionAuthor = new EditionAuthor($object->authorId, $object->authorEmail);
                $edition = new Edition($timestamp, $editionAuthor);
                $this->editionsStorage->addNewEdition($edition);
            }
        }
    }

    public function getEditionsStorage(){
        return $this->editionsStorage;
    }
}