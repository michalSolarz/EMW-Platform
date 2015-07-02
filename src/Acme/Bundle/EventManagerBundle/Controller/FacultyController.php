<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\Bundle\EventManagerBundle\Entity\Faculty;
use Acme\Bundle\EventManagerBundle\Form\FacultyType;

/**
 * Faculty controller.
 *
 */
class FacultyController extends Controller
{

    /**
     * Lists all Faculty entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeEventManagerBundle:Faculty')->findAll();

        return $this->render('AcmeEventManagerBundle:Faculty:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Faculty entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Faculty();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_faculty_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeEventManagerBundle:Faculty:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Faculty entity.
     *
     * @param Faculty $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Faculty $entity)
    {
        $form = $this->createForm(new FacultyType(), $entity, array(
            'action' => $this->generateUrl('admin_faculty_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Faculty entity.
     *
     */
    public function newAction()
    {
        $entity = new Faculty();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeEventManagerBundle:Faculty:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Faculty entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Faculty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculty entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:Faculty:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Faculty entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_faculty_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Faculty entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Faculty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculty entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:Faculty:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Faculty entity.
     *
     * @param Faculty $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Faculty $entity)
    {
        $form = $this->createForm(new FacultyType(), $entity, array(
            'action' => $this->generateUrl('admin_faculty_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Faculty entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Faculty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculty entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_faculty_edit', array('id' => $id)));
        }

        return $this->render('AcmeEventManagerBundle:Faculty:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Faculty entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeEventManagerBundle:Faculty')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Faculty entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_faculty'));
    }
}
