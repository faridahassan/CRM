<?php

namespace Crm\SandboxBundle\Controller\Marketing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArchivedLeadsController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        // Geehint: Update later to be calculated! query_builder in form type. Then update UserRepository findByRole to accept array
        
        $leads      = $em->getRepository("CrmSandboxBundle:Lead")->getArchivedLeads();
        $salesReps = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_REPRESENTATIVE');
        $teamleads = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_SALES_MANAGER');
        $admins    = $em->getRepository("CrmSandboxBundle:User")->findByRole('ROLE_ADMIN');   
        $admins = array_merge($teamleads, $admins);   
        $salesReps = array_merge($salesReps, $admins);    
        return $this->render('CrmSandboxBundle:Marketing/ArchivedLeads:index.html.twig',array('leads' => $leads, 'salesReps' => $salesReps));
    }
}
