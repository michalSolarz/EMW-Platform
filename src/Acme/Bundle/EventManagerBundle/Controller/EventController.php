<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Acme\Bundle\EventManagerBundle\Entity\Event;
use Acme\Bundle\EventManagerBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{

    /**
     * Lists all Event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeEventManagerBundle:Event')->getAllEventsWithParticipantsNumber();

        return $this->render('AcmeEventManagerBundle:Event:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Event entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Event();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->get('acme_event_manager.creation_handler')->handleCreation($entity);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('event'));
        }

        return $this->render('AcmeEventManagerBundle:Event:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Event entity.
     *
     * @param Event $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Event $entity)
    {
        $form = $this->createForm(new EventType(), $entity, array(
            'action' => $this->generateUrl('event_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Event entity.
     *
     */
    public function newAction()
    {
        $entity = new Event();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeEventManagerBundle:Event:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:Event:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:Event:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Event entity.
     *
     * @param Event $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Event $entity)
    {
        $form = $this->createForm(new EventType(), $entity, array(
            'action' => $this->generateUrl('event_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Event entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->get('acme_event_manager.edition_handler')->handleEdition($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('event_edit', array('id' => $id)));
        }

        return $this->render('AcmeEventManagerBundle:Event:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('event'));
    }

    public function eventStatisticsAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $statisticsProvider = $this->get('acme_event_manager.event_statistic_provider');

        return $this->render('@AcmeEventManager/Event/eventStatistics.html.twig', array('participants' => $statisticsProvider->getFullStatistics($entity),
            'event' => $entity));
    }

    public function eventParticipantsAction(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');
        $period = $request->get('period');


        $em = $this->getDoctrine()->getManager();
        $participantsProvider = $this->get('acme_event_manager.event_participants_provider');

        $entity = $em->getRepository('AcmeEventManagerBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }


        return $this->render('@AcmeEventManager/Event/eventParticipants.html.twig', array(
            'parameters' => array(
                'id' => $id,
                'type' => $type,
                'period' => $period,
            ),
            'event' => $entity,
            'participants' => $participantsProvider->provideParticipants($entity, $type, $period),
        ));
    }

    public function exportParticipantsToCSVAction(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');
        $period = $request->get('period');

        $exportHandler = $this->get('acme_event_manager.csv_export_handler');
        $exportHandler->setParametersForEventParticipantsExport(array('id' => $id,
            'type' => $type,
            'period' => $period,
        ));

        $timestamp = new \DateTime('now', new \DateTimeZone('UTC'));
        $filename = 'event-participants-list-export-' . $timestamp->format('Y-m-d H-i-s') . '.csv';
        $response = new StreamedResponse();
        $response->setCallback(function () {
            $this->get('acme_event_manager.csv_export_handler')->exportEventParticipantsList();
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
