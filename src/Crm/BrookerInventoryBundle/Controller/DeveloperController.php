<?php

namespace Crm\BrookerInventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\BrookerInventoryBundle\Entity\Developer;
use Crm\BrookerInventoryBundle\Form\DeveloperType;

/**
 * Developer controller.
 *
 */
class DeveloperController extends Controller
{

    /**
     * Lists all Developer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmBrookerInventoryBundle:Developer')->findAll();

        return $this->render('CrmBrookerInventoryBundle:Developer:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Developer entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Developer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmBrookerInventoryBundle:Developer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Developer entity.
     *
     * @param Developer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Developer $entity)
    {
        $form = $this->createForm(new DeveloperType(), $entity, array(
            'action' => $this->generateUrl('developer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Developer entity.
     *
     */
    public function newAction()
    {
        $entity = new Developer();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmBrookerInventoryBundle:Developer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Developer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Developer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Developer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Developer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Developer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Developer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Developer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Developer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Developer entity.
    *
    * @param Developer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Developer $entity)
    {
        $form = $this->createForm(new DeveloperType(), $entity, array(
            'action' => $this->generateUrl('developer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Developer entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Developer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Developer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmBrookerInventoryBundle:Developer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Developer entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmBrookerInventoryBundle:Developer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Developer entity.');
            }

            $em->remove($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->redirect($this->generateUrl('developer'));
    }

    /**
     * Creates a form to delete a Developer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('developer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
