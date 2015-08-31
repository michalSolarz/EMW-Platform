<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

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

    /**
     * Lists all Paper entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeEventManagerBundle:Paper')->findAll();

        return $this->render('AcmeEventManagerBundle:Paper:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Paper entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Paper();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->get('acme_event_manager.creation_handler')->handleCreation($entity);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('paper_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeEventManagerBundle:Paper:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Paper entity.
     *
     * @param Paper $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Paper $entity)
    {
        $form = $this->createForm(new PaperType(), $entity, array(
            'action' => $this->generateUrl('paper_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Paper entity.
     *
     */
    public function newAction()
    {
        $entity = new Paper();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeEventManagerBundle:Paper:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Paper entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Paper')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paper entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:Paper:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Paper entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paper_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Paper entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Paper')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paper entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeEventManagerBundle:Paper:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Paper entity.
     *
     * @param Paper $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Paper $entity)
    {
        $form = $this->createForm(new PaperType(), $entity, array(
            'action' => $this->generateUrl('paper_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Paper entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEventManagerBundle:Paper')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Paper entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->get('acme_event_manager.edition_handler')->handleEdition($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('paper_edit', array('id' => $id)));
        }

        return $this->render('AcmeEventManagerBundle:Paper:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Paper entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeEventManagerBundle:Paper')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Paper entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('paper'));
    }
}
