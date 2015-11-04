<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Acme\Bundle\EventManagerBundle\Entity\UserData;
use Acme\Bundle\EventManagerBundle\Form\UserDataType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * UserData controller.
 *
 */
class UserDataController extends Controller
{

    /**
     * Creates a new UserData entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new UserData();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->get('acme_event_manager.creation_handler')->handleCreation($entity);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('acme_event_manager_homepage'));
        }

        return $this->render('AcmeEventManagerBundle:UserData:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a UserData entity.
     *
     * @param UserData $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserData $entity)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UserDataType($entityManager, $this->get('acme_event_manager.creation_handler')), $entity, array(
            'action' => $this->generateUrl('user_data_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'forms.user_data.submit.label'));

        return $form;
    }

    /**
     * Displays a form to create a new UserData entity.
     *
     */
    public function newAction()
    {
        $userData = $this->getUser()->getData();

        if ($userData) {
            return $this->redirect($this->generateUrl('user_data_edit'));
        }

        $entity = new UserData();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeEventManagerBundle:UserData:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserData entity.
     *
     */
    public function editAction()
    {
        $userData = $this->getUser()->getData();

        if (!$userData) {
            return $this->redirect($this->generateUrl('user_data_new'));
        }

        $editForm = $this->createEditForm($userData);

        return $this->render('AcmeEventManagerBundle:UserData:edit.html.twig', array(
            'entity' => $userData,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a UserData entity.
     *
     * @param UserData $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UserData $entity)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UserDataType($entityManager, $this->get('acme_event_manager.creation_handler')), $entity, array(
            'action' => $this->generateUrl('user_data_update', array('id' => $entity->getId()))
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing UserData entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:UserData')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserData entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->get('acme_event_manager.edition_handler')->handleEdition($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('acme_event_manager_homepage'));
        }

        return $this->render('AcmeEventManagerBundle:UserData:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }
}
