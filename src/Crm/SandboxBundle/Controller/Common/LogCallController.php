<?php

namespace Crm\SandboxBundle\Controller\Common;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Crm\SandboxBundle\Entity\Call;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Form\CallType;
use Crm\SandboxBundle\Form\LeadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class LogCallController extends Controller
{
    /**
     * @ParamConverter("lead", class="CrmSandboxBundle:Lead")
     */
    public function outboundAction(Request $request, Lead $lead, $orientation)
    {
        $em = $this->getDoctrine()->getManager();
        $isCall = false;
        $call = new Call();

        
        

        $call->setLead($lead);
        $call->setDate(new \DateTime());
        $call->setUser($this->getUser());

        $leadForm = $this->createEditForm($lead);

        if(intval($orientation) == 1){
            
            $isCall = true;
        }
        $call->setIsCall($isCall);
        $callForm = $this->createCallCreateForm($call,$taskId = $request->get('task'));
        

        if($orientation){
            
           
        } else {

            $callForm->remove('orientation');
        }

        return $this->render('CrmSandboxBundle:Common/LogAction:outboundCall.html.twig', array(
            'isCall'   => $isCall,
            'leadId'   => $lead->getId(),
            'leadPotential'   => $lead->getIsLead(),
            'leadPotentialReason'   => $lead->getIsLeadReason(),
            'leadInterest'   => $lead->getIsInterested(),
            'leadInterestReason'   => $lead->getIsInterestedReason(),
            'contact'  => $lead->getContact(),
            'callForm' => $callForm->createView(),
            'leadForm' => $leadForm->createView()
            ));
    }

    /**
    * 
    */
    public function selectLeadAction(Request $request)
    {
        $lead = new Lead();
        $leadForm = $this->createLeadCreateForm(1, $lead);

        $em = $this->getDoctrine()->getManager();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') or $this->get('security.authorization_checker')->isGranted('ROLE_CALL_CENTER') or $this->get('security.authorization_checker')->isGranted('ROLE_MARKETING') ) {
            $leads = $em->getRepository('CrmSandboxBundle:Lead')->findAll();
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SALES_REPRESENTATIVE')) {
            $leads = $this->getUser()->getAssignedLeads();
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SALES_MANAGER')) {
            $teamMembers = $em->getRepository('CrmSandboxBundle:User')->findBy(['team' =>$this->getUser()->getLedTeam()->getId()]);
            $teamMembers = array_merge($teamMembers, [$this->getUser()]);    
            $leads = [];
            foreach ($teamMembers as $teamMember) {
                
                if (empty($teamMember->getAssignedLeads()->getValues())) {
                    $tempLeads = [];
                }
                else
                {
                    $tempLeads = $teamMember->getAssignedLeads()->getValues();
                }
                $leads = array_merge($leads,$tempLeads );    
            }
            
        }
        // exit;
        
        return $this->render('CrmSandboxBundle:Common/LogAction:selectLeadInboundCall.html.twig', array('leads' => $leads, 'leadForm' => $leadForm->createView())); 
    }



    /**
    * 
    */
    public function createLeadAction($orientation,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lead = new Lead();
        $leadForm = $this->createLeadCreateForm($orientation, $lead);

        $leadForm->handleRequest($request);

        if($leadForm->isValid()) {
            
            $lead->setUser($this->getUser());
            $contact = $lead->getContact();
            $contactResult = $em->getRepository('CrmSandboxBundle:contact')->checkIfMobileExists($contact->getMobile(),$contact->getMobile2());
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
                return $this->render('CrmSandboxBundle:Common/LogAction:selectLeadInboundCall.html.twig', array('leads' => $leads, 'leadForm' => $leadForm->createView())); 
            }
            $contact->setLead($lead);
            $em->persist($contact);
              if ($this->getUser()->hasRole('ROLE_SALES_REPRESENTATIVE') or $this->getUser()->hasRole('ROLE_SALES_MANAGER') ){
                $userToAssign = $lead->getAssignedSalesRep();
                if (!$userToAssign) {
                    $this->get('crm.sandboxbundle.leadsManager')->addLeadToSystem($lead,$this->getUser(),$this->getUser());
                }
                else {
                    $this->get('crm.sandboxbundle.leadsManager')->addLeadToSystem($lead,$userToAssign,$this->getUser());   
                }
            }
            else
            {

                $userToAssign = $lead->getAssignedSalesRep();
                $this->get('crm.sandboxbundle.leadsManager')->addLeadToSystem($lead,$userToAssign,$this->getUser());
            }
            $em->persist($lead);
            
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('notice', 'New Lead added  successfully');

            if ($leadForm->get('submit_call')->isClicked()) {
                return $this->redirect($this->generateUrl('callcenter_log_outbound_call', array('id' => $lead->getId(),'orientation' => 1)));    
            } else if ($leadForm->get('submit_meeting')->isClicked()) {
                return $this->redirect($this->generateUrl('callcenter_log_outbound_call', array('id' => $lead->getId(),'orientation' => 0)));
            } else {
                echo "You did not reach this page the right way, please don't copy paste links to your browser";
                exit;
            }

            
        }

        $em = $this->getDoctrine()->getManager();
        $leads = $em->getRepository('CrmSandboxBundle:Lead')->findAll();
        return $this->render('CrmSandboxBundle:Common/LogAction:selectLeadInboundCall.html.twig', array('leads' => $leads, 'leadForm' => $leadForm->createView())); 
    }

    /**
     * Creates a form to create a Lead entity.
     *
     * @param Lead $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLeadCreateForm($orientation, Lead $entity)
    {
        $form = $this->createForm(new LeadType(), $entity, array(
            'action' => $this->generateUrl('callcenter_create_lead', array('orientation' => $orientation)),
            'method' => 'POST',
        ));

        $form->add('isLead', null, ['label' => false]);
        $form->add('isLeadReason', 'choice', [
                    'choices' => [
                        'Age' => 'Age',
                        'Score' => 'Score'
                    ],
                    'required' => false
                ]);
        $form->add('isInterested', null, ['label' => false]);
        $form->add('isInterestedReason', 'choice', [
                    'choices' => [
                        'Age' => 'Age',
                        'Score' => 'Score'
                    ],
                    'required' => false
                ]);

        $form->add('submit_call', 'submit', array('label' => 'Create'));

        $form->add('submit_meeting', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a Call entity.
     *
     * @param Call $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCallCreateForm(Call $entity,$taskId)
    {
        $form = $this->createForm(new CallType(), $entity, array(
            'action' => $this->generateUrl('call_create',array('task' => $taskId)),
            'method' => 'POST',
        ));
        $form->add('time', 'text', array('mapped'=>false));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
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
}
