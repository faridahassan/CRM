<?php

namespace Crm\SandboxBundle\Controller\Sales;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

class AssignLeadsController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        // Geehint: Update later to be calculated! query_builder in form type. Then update UserRepository findByRole to accept array
        if ($this->get('security.context')->isGranted('ROLE_SALES_MANAGER')) {
            $leads      = $em->getRepository("CrmSandboxBundle:Lead")->findBy(['owner'=>$this->getUser(),'assignedSalesRep'=> null,'isInterested'=>true , 'isLead'=>true]);
            $salesReps = $em->getRepository('CrmSandboxBundle:User')->findBy(['team' =>$this->getUser()->getLedTeam()->getId()]);
            $admins    = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_MANAGER');
        }
        else
        {
            $leads = $em->getRepository("CrmSandboxBundle:Lead")->findBy(['owner'=>$this->getUser(),'assignedSalesRep'=> null,'isInterested'=>true , 'isLead'=>true]);
            $salesReps = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_REPRESENTATIVE');
            $teamleads = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_MANAGER');
            $admins    = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_ADMIN');   
            $admins = array_merge($teamleads, $admins);   
        }
        $salesReps = array_merge($salesReps, $admins);    
        return $this->render('CrmSandboxBundle:Sales/AssignLeads:index.html.twig',array('leads' => $leads, 'salesReps' => $salesReps));
    }


    public function manageAssingedLeadsAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->get('security.context')->isGranted('ROLE_SALES_MANAGER')) {
            $leads = $em->getRepository("CrmSandboxBundle:Lead")->findBy(['owner'=>$this->getUser(),'isInterested'=>true , 'isLead'=>true]);
            $salesReps = $em->getRepository('CrmSandboxBundle:User')->findBy(['team' =>$this->getUser()->getLedTeam()->getId()]);
            $admins    = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_MANAGER');
        }
        else
        {
            $leads = $em->getRepository("CrmSandboxBundle:Lead")->findBy(['isInterested'=>true , 'isLead'=>true]);
            $salesReps = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_REPRESENTATIVE');
            $teamleads = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_MANAGER');
            $admins    = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_ADMIN');   
            $admins = array_merge($teamleads, $admins);   
        }
        $salesReps = array_merge($salesReps, $admins);    
        return $this->render('CrmSandboxBundle:Sales/AssignLeads:manage.html.twig',array('leads' => $leads, 'salesReps' => $salesReps));
    }
    /**
     * @ParamConverter("lead", class="CrmSandboxBundle:lead")
     * @ParamConverter("salesRep", class="CrmSandboxBundle:user")
     */
    public function assignSalesRepToLeadAction(Lead $lead, User $salesRep, $wasArchived) {
        if ($wasArchived) {
            $lead->setIsLead(true);
            $lead->setIsInterested(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($lead);
            $em->flush();
            return new JsonResponse(array('state' => "lead status changed"));
        }
        $this->get('crm.sandboxbundle.leadsManager')->addLeadToSystem($lead,$salesRep,$this->getUser());
        return new JsonResponse(array('state' => "success"));
    }

    public function shuffleLeadsAction($includeMe) {
        $em = $this->getDoctrine()->getManager();
        $leads = $em->getRepository("CrmSandboxBundle:Lead")->findBy(['owner'=>$this->getUser(),'assignedSalesRep'=> null,'isInterested'=>true , 'isLead'=>true]);
        $this->get('crm.sandboxbundle.leadsManager')->shuffleLeads($this->getUser(),$leads,$includeMe);
        return new JsonResponse(array('state' => "success"));
    }
}
