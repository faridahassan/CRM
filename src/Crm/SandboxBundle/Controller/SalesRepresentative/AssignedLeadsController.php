<?php

namespace Crm\SandboxBundle\Controller\SalesRepresentative;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AssignedLeadsController extends Controller
{
    public function indexAction()
    {
        $userId = $this->getUser()->getId();
        $em     = $this->getDoctrine()->getManager();
        $leads = $em->getRepository("CrmSandboxBundle:Lead")->findBy(['assignedSalesRep'=>$this->getUser(),'isLead'=>true , 'isInterested'=> true]);
        return $this->render('CrmSandboxBundle:SalesRepresentative/AssignedLeads:index.html.twig',array('leads' => $leads ));
    }

    public function assginedLeadsAction($id,$type)
    {
        $em     = $this->getDoctrine()->getManager();
        $leads = [];
        $object = "hi";
        if ($type == 0)
        {
            
            if($id == 0)
            {
                $object = $this->getUser();
            }
            else
            {
                $object = $em->getRepository('CrmSandboxBundle:User')->find($id);
            }
            $leads  = $object->getAssignedLeads();
            $object = $object->getName();
        }
        else{
            
            if($id == 0)
            {
                
                $teams = $em->getRepository('CrmBrookerInventoryBundle:Team')->findAll();
                foreach ($teams as $team) {
                          foreach ($team->getUsers() as $member) {
                        $memberLeads = $member->getAssignedLeads()->getValues();
                        if($memberLeads)
                            $leads = array_merge($memberLeads,$leads);
                    }
                }
                $object = "All Teams";
              
            }
            else
            {
                
                $object = $em->getRepository('CrmBrookerInventoryBundle:Team')->find($id);
                foreach ($object->getUsers() as $member) {
                    $memberLeads = $member->getAssignedLeads()->getValues();
                    if($memberLeads)
                        $leads = array_merge($memberLeads,$leads);
                }
                $object = $object->getName();
            }
            
        }
        
        
        
        
        

        return $this->render('CrmSandboxBundle:SalesRepresentative/AssignedLeads:assignedLeads_Widget.html.twig',array('object'=>$object,'leads' => $leads ));
    }
}
