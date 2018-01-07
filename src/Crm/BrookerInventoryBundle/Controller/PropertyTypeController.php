<?php

namespace Crm\BrookerInventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\BrookerInventoryBundle\Entity\PropertyType;
use Crm\BrookerInventoryBundle\Form\PropertyTypeType;

/**
 * PropertyType controller.
 *
 */
class PropertyTypeController extends Controller
{

    /**
     * Lists all PropertyType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmBrookerInventoryBundle:PropertyType')->findAll();

        return $this->render('CrmBrookerInventoryBundle:PropertyType:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PropertyType entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PropertyType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmBrookerInventoryBundle:PropertyType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PropertyType entity.
     *
     * @param PropertyType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PropertyType $entity)
    {
        $form = $this->createForm(new PropertyTypeType(), $entity, array(
            'action' => $this->generateUrl('propertytype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PropertyType entity.
     *
     */
    public function newAction()
    {
        $entity = new PropertyType();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmBrookerInventoryBundle:PropertyType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PropertyType entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:PropertyType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PropertyType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:PropertyType:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PropertyType entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:PropertyType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PropertyType entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:PropertyType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PropertyType entity.
    *
    * @param PropertyType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PropertyType $entity)
    {
        $form = $this->createForm(new PropertyTypeType(), $entity, array(
            'action' => $this->generateUrl('propertytype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PropertyType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:PropertyType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PropertyType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('propertytype_edit', array('id' => $id)));
        }

        return $this->render('CrmBrookerInventoryBundle:PropertyType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PropertyType entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmBrookerInventoryBundle:PropertyType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PropertyType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('propertytype'));
    }

    /**
     * Creates a form to delete a PropertyType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('propertytype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
