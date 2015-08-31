<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 02.08.15
 * Time: 14:11
 */

namespace Acme\Bundle\EventManagerBundle\Model;


class EditionAuthor
{
    private $authorId;

    private $authorEmail;

    public function __construct($authorId, $authorEmail)
    {
        $this->authorId = $authorId;
        $this->authorEmail = $authorEmail;
    }

    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

}