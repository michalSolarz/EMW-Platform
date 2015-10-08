<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Acme\Bundle\EventManagerBundle\Entity\EventParticipants;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
//        $ch = $this->get('acme_event_manager.creation_handler');
        $event = $em->getRepository('AcmeEventManagerBundle:Event')->find(1);
//        $repo = $em->getRepository('AcmeEventManagerBundle:EventParticipants')->countParticipantsFromDaysBefore($event, 1000);
        $user = $this->getUser();
        $a = $em->getRepository('AcmeEventManagerBundle:Paper')->getAllPapers($event);
//        $b = $a->provideParticipants($event, 'a', 0);
//        $repo = $em->getRepository('AcmeEventManagerBundle:EventParticipants');
//        $participants = $repo->countAllParticipants($event);
        var_dump($a);


//        $eventParticipant = new EventParticipants();
//        $eventParticipant->setUser($user);
//        $eventParticipant->setEvent($event);
//
//        $ch->handleCreation($eventParticipant);
//
//        $em->persist($eventParticipant);

//        $em->flush();

        return $this->render('AcmeEventManagerBundle:Default:index.html.twig', array('event' => 1));
    }
}
