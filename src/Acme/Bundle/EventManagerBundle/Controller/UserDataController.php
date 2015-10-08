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
     * Lists all UserData entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeEventManagerBundle:UserData')->findAll();

        return $this->render('AcmeEventManagerBundle:UserData:index.html.twig', array(
            'entities' => $entities,
        ));
    }

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
            return $this->redirect($this->generateUrl('user_data_show', array('id' => $entity->getId())));
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
        $entity = new UserData();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeEventManagerBundle:UserData:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserData entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:UserData')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserData entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:UserData:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a UserData entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_data_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing UserData entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:UserData')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserData entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:UserData:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->get('acme_event_manager.edition_handler')->handleEdition($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_data_edit', array('id' => $id)));
        }

        return $this->render('AcmeEventManagerBundle:UserData:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserData entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeEventManagerBundle:UserData')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserData entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_data'));
    }
}
