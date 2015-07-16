<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Acme\Bundle\EventManagerBundle\Model\Edition;
use Acme\Bundle\EventManagerBundle\Model\Editions;
use Acme\Bundle\EventManagerBundle\Model\EditionsJsonDeserializer;
use Acme\Bundle\EventManagerBundle\Model\EditionsJsonSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->getDoctrine();
        $user = $em->getRepository('AcmeEventManagerBundle:User')->find(1);
        $edition1 = new Edition(new \DateTime('now', new \DateTimeZone('UTC')), $user);
        $edition2 = new Edition(new \DateTime('2015-07-15'), $user);

        $editionsStorage = new Editions();
        $editionsStorage->addNewEdition($edition1);
        $editionsStorage->addNewEdition($edition2);

        $json = new EditionsJsonSerializer($editionsStorage);
        var_dump($json->getJsonStringFromStorage());

        $deserializer = new EditionsJsonDeserializer(new Editions(), $em->getRepository('AcmeEventManagerBundle:User'), '{}');

        $deserializer->deserializeJson();

//        var_dump($em->getRepository('AcmeEventManagerBundle:User'));


        return $this->render('AcmeEventManagerBundle:Default:index.html.twig', array('name' => $name));
    }
}
