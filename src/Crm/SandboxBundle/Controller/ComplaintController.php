<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Crm\SandboxBundle\Entity\Complaint;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Entity\Contact;
use Crm\SandboxBundle\Entity\ComplaintLog;
use Crm\SandboxBundle\Form\ComplaintType;
use Crm\SandboxBundle\Form\ComplaintLogType;
use Crm\SandboxBundle\Form\ComplaintWithLeadType;

/**
 * Complaint controller.
 *
 */
class ComplaintController extends Controller
{

    /**
     * Lists all Complaint entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CrmSandboxBundle:Complaint')->findAll();

        return $this->render('CrmSandboxBundle:Complaint:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Complaint entity.
     *
     */
    public function createAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Complaint();
        $entity->setLead($em->getRepository('CrmSandboxBundle:Lead')->find($id));
        $form = $this->createCreateForm($entity,$id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setDate(new \Datetime('now'));
            $entity->setUserCreating($this->getUser());
            $entity->setStatus("New");
            $em->persist($entity);
            $em->flush();

            $session = new Session();
            $session->getFlashBag()->add('notice', 'Complaint completed successfuly');
            return $this->redirect($this->generateUrl('complaint_search'));
        }

        return $this->render('CrmSandboxBundle:Complaint:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Complaint entity.
     *
     */
    public function createLeadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Complaint();
        $lead = new Lead();

        $form = $this->createForm(new ComplaintWithLeadType(), $entity, array(
            'action' => $this->generateUrl('complaint_create_lead'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        $form->handleRequest($request);
        $contactResult = $em->getRepository('CrmSandboxBundle:contact')->checkIfMobileExists($entity->getMobile(),$entity->getMobile());
            if(!empty($contactResult))
            {
                 $session = new Session();
                 if ($contactResult[0]->getLead()->getOwner()) {
                     $owner_name=$contactResult[0]->getLead()->getOwner()->getName();
                     $message = 'This lead already exists and is owned by '. $owner_name;
                 }
                else{
                    $message = 'This lead already exists';   
                }
                 
                 $session->getFlashBag()->add('error', $message);
                $leads = $em->getRepository('CrmSandboxBundle:Lead')->findAll();
                return $this->render('CrmSandboxBundle:Complaint:new_lead.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
            }
            $contact = new Contact();
            $contact->setName($entity->getName());
            $contact->setMobile($entity->getMobile());

            $lead->setContact($contact);
            $lead->setIsLead(false);
            $lead->setComplaint(true);
            $contact->setLead($lead);
            $entity->setLead($lead);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setDate(new \Datetime('now'));
            $entity->setUserCreating($this->getUser());
            $entity->setStatus("new");
            $em->persist($entity);
            $em->persist($contact);
            $em->persist($lead);
            $em->flush();

            $session = new Session();
            $session->getFlashBag()->add('notice', 'Complaint completed successfuly');
            return $this->redirect($this->generateUrl('complaint_search'));
        }

        return $this->render('CrmSandboxBundle:Complaint:new_lead.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Complaint entity.
     *
     * @param Complaint $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Complaint $entity,$id)
    {
        $form = $this->createForm(new ComplaintType(), $entity, array(
            'action' => $this->generateUrl('complaint_create', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Complaint entity.
     *
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Complaint();
        $entity->setLead($em->getRepository('CrmSandboxBundle:Lead')->find($id));
        $form   = $this->createCreateForm($entity,$id);
        $entities = $em->getRepository('CrmSandboxBundle:Complaint')->findAll();

        return $this->render('CrmSandboxBundle:Complaint:new.html.twig', array(
            'entity' => $entity,
            'entities' => $entities,
            'form'   => $form->createView(),
        ));
    }

     /**
     * Displays a form to create a new Complaint entity.
     *
     */
    public function newLeadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Complaint();
        
        $form = $this->createForm(new ComplaintWithLeadType(), $entity, array(
            'action' => $this->generateUrl('complaint_create_lead'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        $entities = $em->getRepository('CrmSandboxBundle:Complaint')->findAll();

        return $this->render('CrmSandboxBundle:Complaint:new_lead.html.twig', array(
            'entity' => $entity,
            'entities' => $entities,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Complaint entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Complaint')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Complaint entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $complaintLog = new ComplaintLog();
        $complaintLog->setComplaint($entity);
        $form = $this->createForm(new ComplaintLogType(), $complaintLog, array(
            'action' => $this->generateUrl('complaintlog_create',array('id' => $entity->getId())),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Log'));

        return $this->render('CrmSandboxBundle:Complaint:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Complaint entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Complaint')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Complaint entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Complaint:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Complaint entity.
    *
    * @param Complaint $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Complaint $entity)
    {
        $form = $this->createForm(new ComplaintType(), $entity, array(
            'action' => $this->generateUrl('complaint_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Complaint entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Complaint')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Complaint entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('complaint_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:Complaint:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Complaint entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Complaint')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Complaint entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('complaint'));
    }

     public function closeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Complaint')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Complaint entity.');
            }
            $entity->setStatus("closed");
            $entity->setUserClosing($this->getUser());
            $entity->setClosedDate( new \Datetime('now'));
            $em->flush();
        return new JsonResponse("success");
    }
    /**
     * Creates a form to delete a Complaint entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('complaint_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function searchAction()
    {
        return $this->render('CrmSandboxBundle:Lead:search.html.twig');
    }
}
