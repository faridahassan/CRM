<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Crm\SandboxBundle\Entity\ComplaintLog;
use Crm\SandboxBundle\Form\ComplaintLogType;

/**
 * ComplaintLog controller.
 *
 */
class ComplaintLogController extends Controller
{

    /**
     * Lists all ComplaintLog entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:ComplaintLog')->findAll();

        return $this->render('CrmSandboxBundle:ComplaintLog:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ComplaintLog entity.
     *
     */
    public function createAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new ComplaintLog();
        $entity->setComplaint($em->getRepository('CrmSandboxBundle:Complaint')->find($id));
        $form = $this->createCreateForm($entity,$id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $entity->setDate(new \Datetime('now'));
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('complaint_show', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:ComplaintLog:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ComplaintLog entity.
     *
     * @param ComplaintLog $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ComplaintLog $entity,$id)
    {
        $form = $this->createForm(new ComplaintLogType(), $entity, array(
            'action' => $this->generateUrl('complaintlog_create',array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Log'));

        return $form;
    }

    /**
     * Displays a form to create a new ComplaintLog entity.
     *
     */
    public function newAction()
    {
        $entity = new ComplaintLog();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:ComplaintLog:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ComplaintLog entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:ComplaintLog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComplaintLog entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:ComplaintLog:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ComplaintLog entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:ComplaintLog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComplaintLog entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:ComplaintLog:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ComplaintLog entity.
    *
    * @param ComplaintLog $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ComplaintLog $entity)
    {
        $form = $this->createForm(new ComplaintLogType(), $entity, array(
            'action' => $this->generateUrl('complaintlog_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ComplaintLog entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:ComplaintLog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComplaintLog entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('complaintlog_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:ComplaintLog:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ComplaintLog entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:ComplaintLog')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ComplaintLog entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('complaintlog'));
    }

    /**
     * Creates a form to delete a ComplaintLog entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('complaintlog_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
