<?php

namespace Crm\SandboxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Form\LeadType;

/**
 * Lead controller.
 *
 */
class LeadController extends Controller
{

    public function historyAction($leadId)
    {

        $reader = $this->get('crm.auditingbundle.auditTransformer');
        $history = $reader->getHistory('Crm\SandboxBundle\Entity\Lead', $leadId);

        return $this->render('CrmSandboxBundle:Lead:history.html.twig', $history);
    }

    /**
     * Lists all Lead entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmSandboxBundle:Lead')->findAll();

        return $this->render('CrmSandboxBundle:Lead:index.html.twig', array(
            'entities' => $entities,
            ));
    }
    /**
     * Creates a new Lead entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Lead();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lead_show', array('id' => $entity->getId())));
        }

        return $this->render('CrmSandboxBundle:Lead:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            ));
    }

    /**
     * Creates a form to create a Lead entity.
     *
     * @param Lead $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lead $entity)
    {
        $form = $this->createForm(new LeadType(), $entity, array(
            'action' => $this->generateUrl('lead_create'),
            'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lead entity.
     *
     */
    public function newAction()
    {
        $entity = new Lead();
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:Lead:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            ));
    }

    /**
     * Finds and displays a Lead entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Lead')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lead entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Lead:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing Lead entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Lead')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lead entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmSandboxBundle:Lead:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * @ParamConverter("lead", class="CrmSandboxBundle:Lead")
     */
    public function updateAssignmentAction(Lead $lead,$slug)
    {
        $em = $this->getDoctrine()->getManager();

        $lead->setEvaluation($slug);

        $em->persist($lead);
        $em->flush();
        return new JsonResponse(array('state' => 'success'));
    }

    /**
     * @ParamConverter("lead", class="CrmSandboxBundle:Lead")
     */
    public function updatePotentialAction(Lead $lead,$potential,$reason)
    {
        $em = $this->getDoctrine()->getManager();
        $lead->setIsLead($potential);
        if(!$potential){
            $lead->setOwner(null);
            $lead->setAssignedSalesRep(null);
        }
        if (isset($reason))
            $lead->setIsLeadReason($reason);
        $em->persist($lead);
        $em->flush();
        return new JsonResponse(array('state' => $potential));
    }

    /**
     * @ParamConverter("lead", class="CrmSandboxBundle:Lead")
     */
    public function updateInterestAction(Lead $lead,$interest,$reason)
    {
        $em = $this->getDoctrine()->getManager();
        $lead->setIsInterested($interest);
        if(!$interest){
            $lead->setOwner(null);
            $lead->setAssignedSalesRep(null);
        }
        if (isset($reason))
            $lead->setIsInterestedReason($reason);
        $em->persist($lead);
        $em->flush();
        return new JsonResponse(array('state' => $interest));
    }

    /**
    * Creates a form to edit a Lead entity.
    *
    * @param Lead $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lead $entity)
    {
        $form = $this->createForm(new LeadType(), $entity, array(
            'action' => $this->generateUrl('lead_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Lead entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Lead')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lead entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lead_edit', array('id' => $id)));
        }

        return $this->render('CrmSandboxBundle:Lead:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            ));
    }
    /**
     * Deletes a Lead entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmSandboxBundle:Lead')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lead entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lead'));
    }

    /**
     * Creates a form to delete a Lead entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('lead_delete', array('id' => $id)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'Delete'))
        ->getForm()
        ;
    }

    public function getLeadAction($mobile)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmSandboxBundle:Contact')->findBy(['mobile'=>$mobile]);
        if(empty($entity))
        {
            $entity = $em->getRepository('CrmSandboxBundle:Contact')->findBy(['mobile2'=> $mobile]);
        }
        $lead="";
        if (!empty($entity)) {
            $lead = $entity[0]->getLead();
        }
        return $this->render('CrmSandboxBundle:Lead:complaint_list.html.twig', array(
            'lead'      =>$lead ,
            ));
    }
    public function leadByAnyAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') or $this->get('security.authorization_checker')->isGranted('ROLE_CALL_CENTER') or $this->get('security.authorization_checker')->isGranted('ROLE_MARKETING') ) {
            $leads = $em->getRepository('CrmSandboxBundle:Lead')->findLeadByAny($slug);
        }
        else
        {
            $leads = $em->getRepository('CrmSandboxBundle:Lead')->findLeadByAnyUser($slug,$this->getUser());   
        }
        return $this->render('CrmSandboxBundle:Lead:find_lead_by.html.twig', array('leads'=>$leads,));
    }

}
