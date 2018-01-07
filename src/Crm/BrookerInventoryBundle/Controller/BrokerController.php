<?php

namespace Crm\BrookerInventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\BrookerInventoryBundle\Entity\Broker;
use Crm\BrookerInventoryBundle\Form\BrokerType;

/**
 * Broker controller.
 *
 */
class BrokerController extends Controller
{

    /**
     * Lists all Broker entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmBrookerInventoryBundle:Broker')->findAll();

        return $this->render('CrmBrookerInventoryBundle:Broker:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Broker entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Broker();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmBrookerInventoryBundle:Broker:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Broker entity.
     *
     * @param Broker $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Broker $entity)
    {
        $form = $this->createForm(new BrokerType(), $entity, array(
            'action' => $this->generateUrl('broker_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Broker entity.
     *
     */
    public function newAction()
    {
        $entity = new Broker();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmBrookerInventoryBundle:Broker:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Broker entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Broker')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Broker entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Broker:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Broker entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Broker')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Broker entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Broker:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Broker entity.
    *
    * @param Broker $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Broker $entity)
    {
        $form = $this->createForm(new BrokerType(), $entity, array(
            'action' => $this->generateUrl('broker_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Broker entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Broker')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Broker entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmBrookerInventoryBundle:Broker:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Broker entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmBrookerInventoryBundle:Broker')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Broker entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('broker'));
    }

    /**
     * Creates a form to delete a Broker entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('broker_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
