<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Crm\SandboxBundle\Entity\Channel;
use Crm\SandboxBundle\Form\ChannelType;

/**
 * Channel controller.
 *
 */
class ChannelController extends Controller
{

    /**
     * Lists all Channel entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:Channel')->findAll();

        return $this->render('CrmSandboxBundle:Channel:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Channel entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Channel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('marketing_campaign_manage'));
        }

        return $this->render('CrmSandboxBundle:Channel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Channel entity.
     *
     * @param Channel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Channel $entity)
    {
        $form = $this->createForm(new ChannelType(), $entity, array(
            'action' => $this->generateUrl('channel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Channel entity.
     *
     */
    public function newAction()
    {
        $entity = new Channel();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:Channel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Channel entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Channel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Channel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Channel:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Channel entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Channel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Channel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Channel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function hideAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Channel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Channel entity.');
        }

        $entity->setHide(true);
        foreach ($entity->getSubChannels() as $campaign) {
            $campaign->setHide(true);
        }
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('marketing_campaign_manage'));
    }

    /**
    * Creates a form to edit a Channel entity.
    *
    * @param Channel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Channel $entity)
    {
        $form = $this->createForm(new ChannelType(), $entity, array(
            'action' => $this->generateUrl('channel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Channel entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Channel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Channel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('notice', 'Campagin has been successfully  updated');
            return $this->redirect($this->generateUrl('marketing_campaign_manage'));
        }

        return $this->render('CrmSandboxBundle:Channel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Channel entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Channel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Channel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('channel'));
    }

    /**
     * Creates a form to delete a Channel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('channel_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
