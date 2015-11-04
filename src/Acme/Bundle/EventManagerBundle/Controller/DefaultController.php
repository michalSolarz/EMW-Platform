<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homeAction()
    {
        return $this->render('@AcmeEventManager/Default/home.html.twig', array('user' => $this->getUser()));
    }
}
