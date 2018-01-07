<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Crm\SandboxBundle\Entity\SubChannel;
use Crm\SandboxBundle\Form\SubChannelType;

/**
 * SubChannel controller.
 *
 */
class SubChannelController extends Controller
{

    /**
     * Lists all SubChannel entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:SubChannel')->findAll();

        return $this->render('CrmSandboxBundle:SubChannel:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SubChannel entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SubChannel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('marketing_campaign_manage'));
        }

        return $this->render('CrmSandboxBundle:SubChannel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SubChannel entity.
     *
     * @param SubChannel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SubChannel $entity)
    {
        $form = $this->createForm(new SubChannelType(), $entity, array(
            'action' => $this->generateUrl('subchannel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SubChannel entity.
     *
     */
    public function newAction()
    {
        $entity = new SubChannel();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:SubChannel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SubChannel entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:SubChannel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubChannel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:SubChannel:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SubChannel entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:SubChannel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubChannel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:SubChannel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function hideAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:SubChannel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Channel entity.');
        }

        $entity->setHide(true);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('marketing_campaign_manage'));
    }

    /**
    * Creates a form to edit a SubChannel entity.
    *
    * @param SubChannel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SubChannel $entity)
    {
        $form = $this->createForm(new SubChannelType(), $entity, array(
            'action' => $this->generateUrl('subchannel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SubChannel entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:SubChannel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubChannel entity.');
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

        return $this->render('CrmSandboxBundle:SubChannel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SubChannel entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:SubChannel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SubChannel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subchannel'));
    }

    /**
     * Creates a form to delete a SubChannel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subchannel_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
