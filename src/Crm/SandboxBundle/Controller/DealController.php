<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use Crm\SandboxBundle\Entity\Deal;
use Crm\SandboxBundle\Form\DealType;

/**
 * Deal controller.
 *
 */
class DealController extends Controller
{

    /**
     * Lists all Deal entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:Deal')->findAll();
        


        return $this->render('CrmSandboxBundle:Deal:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Deal entity.
     *
     */
    public function createAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $property = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);
        $entity = new Deal();
        $entity->setUser($this->getUser());
        $entity->setApproved(0);
        $entity->setProperty($property);
        $entity->setDate(new \DateTime('now'));
        $form = $this->createCreateForm($entity,$id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $property = $entity->getProperty();
            if ($entity->getPrice()) {
                $property->setIsSold(true);
            }

            
            $em->persist($property);
            $em->persist($entity);
            $em->flush();
            $this->get('crm.notificationBundle.notificationManager')->dealNotification($entity,"Create");
            $session = new Session();
            $session->getFlashBag()->add('notice', 'Deal Added successfully.');
            if($this->getUser()->hasRole('ROLE_ADMIN'))
                return $this->redirect($this->generateUrl('sales_deals'));
            else
                return $this->redirect($this->generateUrl('sales_representative_deals'));
        }

        return $this->render('CrmSandboxBundle:Sales/Deals:new.html.twig', array(
            'entity' => $entity,
            'property' => $property,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Deal entity.
     *
     * @param Deal $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Deal $entity,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new DealType($em), $entity, array(
            'action' => $this->generateUrl('deal_create', array('id'=>$id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Deal entity.
     *
     */
    public function newAction($id)
    {
        $entity = new Deal();
        $em = $this->getDoctrine()->getManager();
        $property = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);
        $entity->setProperty($property);
        $form   = $this->createCreateForm($entity,$id);
        return $this->render('CrmSandboxBundle:Deal:new.html.twig', array(
            'entity' => $entity,
            'property' => $property,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Deal entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Deal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Deal:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Deal entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Deal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deal entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Deal:edit.html.twig', array(
            'entity'      => $entity,
            'property'      => $entity->getProperty(),
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Deal entity.
    *
    * @param Deal $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Deal $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new DealType($em), $entity, array(
            'action' => $this->generateUrl('deal_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Deal entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Deal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('crm.notificationBundle.notificationManager')->dealNotification($entity,"Edit");
            return $this->redirect($this->generateUrl('deal_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:Deal:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Deal entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Deal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Deal entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('crm.notificationBundle.notificationManager')->dealNotification($entity,"Delete");
        }
        if ($this->getUser()->hasRole('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('sales_deals'));
        if ($this->getUser()->hasRole('ROLE_SALES_REPRESENTATIVE'))
            return $this->redirect($this->generateUrl('sales_representative_deals'));
        return $this->redirect($this->generateUrl('inventory_inventory'));
    }

    /**
     * Creates a form to delete a Deal entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deal_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
