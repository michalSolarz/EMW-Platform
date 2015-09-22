<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventUserController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('AcmeEventManagerBundle:Event');
        $events = $repo->getActiveAndVisibleEvents();
        return $this->render('AcmeEventManagerBundle:EventUser:index.html.twig', array(
            'events' => $events,
            'eventParticipants' => $em->getRepository('AcmeEventManagerBundle:EventParticipants'),
            'papersRepository' => $em->getRepository('AcmeEventManagerBundle:Paper'),
            'user' => $this->getUser()
        ));
    }


    public function joinToEventAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $participationHandler = $this->get('acme_event_manager.event_participation_handler');
        $eventEntity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$eventEntity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $participationHandler->joinEvent($eventEntity);

        return $this->redirect($this->generateUrl('list_visible_available_events'));
    }

    public function leaveEventAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $participationHandler = $this->get('acme_event_manager.event_participation_handler');
        $eventEntity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$eventEntity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $participationHandler->leaveEvent($eventEntity);

        return $this->redirect($this->generateUrl('list_visible_available_events'));
    }

    public function pastEventsAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('AcmeEventManagerBundle:Event');
        $pastEvents = $repo->getPastEvents();
        return $this->render('@AcmeEventManager/EventUser/pastEvents.html.twig', array(
            'pastEvents' => $pastEvents
        ));
    }


}
