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
        $userData = $this->getUser()->getData();
        if ($userData == null)
            return $this->redirect($this->generateUrl('user_data_new', array('dataRequired' => true)));

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

    public function paperContentAction($paperId)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Paper')->getPaperContent($paperId);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paper entity.');
        }

        return $this->render('@AcmeEventManager/Paper/content.html.twig', array('paper' => $entity));
    }

    public function exportPapersToPdfAction(Request $request)
    {
        $eventId = $request->get('eventId');
        $type = $request->get('type');
        $period = $request->get('period');

        $em = $this->getDoctrine();
        $paperProvider = $this->get('acme_event_manager.event_papers_provider');

        $event = $em->getRepository('AcmeEventManagerBundle:Event')->find($eventId);
        $entities = $paperProvider->providePapers($event, $type, $period, true);
        $collection = array();
        foreach ($entities as $entity) {
            $collection[] = $this->renderView('@AcmeEventManager/Paper/pdf-export.html.twig', array('paper' => $entity));
        }
        return $this->get('acme_event_manager.pdf_export_handler')->exportToMultiplePagesPdf($collection);
    }

}
