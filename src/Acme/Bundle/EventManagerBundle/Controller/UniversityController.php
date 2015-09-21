<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Acme\Bundle\EventManagerBundle\Entity\University;
use Acme\Bundle\EventManagerBundle\Form\UniversityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * University controller.
 *
 */
class UniversityController extends Controller
{

    /**
     * Lists all University entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeEventManagerBundle:University')->findAll();

        return $this->render('AcmeEventManagerBundle:University:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new University entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new University();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->get('acme_event_manager.creation_handler')->handleCreation($entity);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_university_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeEventManagerBundle:University:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a University entity.
     *
     * @param University $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(University $entity)
    {
        $form = $this->createForm(new UniversityType(), $entity, array(
            'action' => $this->generateUrl('admin_university_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new University entity.
     *
     */
    public function newAction()
    {
        $entity = new University();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeEventManagerBundle:University:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a University entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:University')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find University entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:University:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a University entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_university_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing University entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:University')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find University entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:University:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a University entity.
     *
     * @param University $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(University $entity)
    {
        $form = $this->createForm(new UniversityType(), $entity, array(
            'action' => $this->generateUrl('admin_university_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing University entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:University')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find University entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->get('acme_event_manager.edition_handler')->handleEdition($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_university', array('id' => $id)));
        }

        return $this->render('AcmeEventManagerBundle:University:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a University entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeEventManagerBundle:University')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find University entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_university'));
    }

    public function importUniversitiesListFromCsvAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('submitFile', 'file', array('label' => 'File to Submit'))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {

                $file = $form->get('submitFile');

                $results = $this->get('acme_event_manager.csv_parser')->parseUniqueEntriesCSV($file->getData());

                if ($this->get('acme_event_manager.csv_import_handler')->importUniversityList($results))
                    return $this->redirect($this->generateUrl('admin_university'));

            }

        }

        return $this->render('@AcmeEventManager/University/importUniversitiesFromCsv.html.twig',
            array('form' => $form->createView(),)
        );
    }

    public function exportUniversitiesListToCsvAction()
    {
        $timestamp = new \DateTime('now', new \DateTimeZone('UTC'));
        $filename = 'universities-list-export-' . $timestamp->format('Y-m-d H-i-s') . '.csv';
        $response = new StreamedResponse();
        $response->setCallback(function () {
            $this->get('acme_event_manager.csv_export_handler')->exportCountryList();
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
