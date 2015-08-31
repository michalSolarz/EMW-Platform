<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.07.15
 * Time: 17:41
 */

namespace Acme\Bundle\EventManagerBundle\Model;

class EditionsJsonSerializer implements EditionsSerializerInterface
{
    private $editionsStorage;
    private $editions = array();

    public function __construct(EditionsStorageInterface $editionsStorage)
    {
        $this->editionsStorage = $editionsStorage->getStorage();
    }

    public function getJsonStringFromStorage()
    {
        $i = 1;
        foreach ($this->editionsStorage as $edition) {
            $timestamp = $edition->getTimestamp();
            $author = $edition->getEditionAuthor();

            $this->editions['editions']['edition ' . $i] = array('timestamp' => array(
                'time' => $timestamp->format('Y-m-d h:i:s'),
                'timezone' => $timestamp->getTimezone()),
                'authorId' => $author->getAuthorId(),
                'authorEmail' => $author->getAuthorEmail());
            $i++;
        }

        return json_encode($this->editions);
    }
}