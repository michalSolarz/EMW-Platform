<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Acme\Bundle\EventManagerBundle\Entity\Event;
use Acme\Bundle\EventManagerBundle\Entity\Paper;
use Acme\Bundle\EventManagerBundle\Form\PaperType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paper controller.
 *
 */
class PaperController extends Controller
{
    public function addPaperAction(Request $request, $eventId)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $additionHandler = $this->get('acme_event_manager.paper_addition_handler');

        $paper = new Paper();

        $eventEntity = $additionHandler->handleAddition($paper, $eventId);

        if (!$eventEntity)
            return $this->redirect($this->generateUrl('list_visible_available_events'));

        $form = $this->createAddForm($paper, $eventEntity);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em->persist($paper);
            $em->flush();
            return $this->redirect($this->generateUrl('list_visible_available_events'));
        }
        return $this->render('AcmeEventManagerBundle:Paper:addPaper.html.twig', array(
            'entity' => $paper,
            'form' => $form->createView(),
        ));
    }

    private function createAddForm(Paper $paper, Event $event)
    {
        $form = $this->createForm(new PaperType($event), $paper, array(
            'action' => $this->generateUrl('add_paper', array('eventId' => $event->getId())),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }


}
