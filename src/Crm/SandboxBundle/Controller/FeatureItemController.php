<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\SandboxBundle\Entity\FeatureItem;
use Crm\SandboxBundle\Form\FeatureItemType;

/**
 * FeatureItem controller.
 *
 */
class FeatureItemController extends Controller
{

    /**
     * Lists all FeatureItem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:FeatureItem')->findAll();

        return $this->render('CrmSandboxBundle:FeatureItem:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new FeatureItem entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new FeatureItem();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmSandboxBundle:FeatureItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FeatureItem entity.
     *
     * @param FeatureItem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(FeatureItem $entity)
    {
        $form = $this->createForm(new FeatureItemType(), $entity, array(
            'action' => $this->generateUrl('featureitem_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FeatureItem entity.
     *
     */
    public function newAction()
    {
        $entity = new FeatureItem();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:FeatureItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FeatureItem entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:FeatureItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeatureItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:FeatureItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FeatureItem entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:FeatureItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeatureItem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:FeatureItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FeatureItem entity.
    *
    * @param FeatureItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FeatureItem $entity)
    {
        $form = $this->createForm(new FeatureItemType(), $entity, array(
            'action' => $this->generateUrl('featureitem_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FeatureItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:FeatureItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FeatureItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('featureitem_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:FeatureItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FeatureItem entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:FeatureItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FeatureItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('featureitem'));
    }

    /**
     * Creates a form to delete a FeatureItem entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('featureitem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
