<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\Bundle\EventManagerBundle\Entity\University;
use Acme\Bundle\EventManagerBundle\Form\UniversityType;

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
            $em->flush();

            return $this->redirect($this->generateUrl('admin_university_edit', array('id' => $id)));
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
}
