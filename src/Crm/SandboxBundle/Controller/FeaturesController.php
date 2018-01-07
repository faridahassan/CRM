<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\SandboxBundle\Entity\Features;
use Crm\SandboxBundle\Form\FeaturesType;

/**
 * Features controller.
 *
 */
class FeaturesController extends Controller
{

    /**
     * Lists all Features entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:Features')->findAll();

        return $this->render('CrmSandboxBundle:Features:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Features entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Features();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmSandboxBundle:Features:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Features entity.
     *
     * @param Features $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Features $entity)
    {
        $form = $this->createForm(new FeaturesType(), $entity, array(
            'action' => $this->generateUrl('features_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Features entity.
     *
     */
    public function newAction()
    {
        $entity = new Features();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:Features:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Features entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Features')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Features entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Features:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Features entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Features')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Features entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Features:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Features entity.
    *
    * @param Features $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Features $entity)
    {
        $form = $this->createForm(new FeaturesType(), $entity, array(
            'action' => $this->generateUrl('features_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Features entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Features')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Features entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->render('CrmSandboxBundle:Features:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Features entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Features')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Features entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('inventory_manage'));
    }

    /**
     * Creates a form to delete a Features entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('features_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
