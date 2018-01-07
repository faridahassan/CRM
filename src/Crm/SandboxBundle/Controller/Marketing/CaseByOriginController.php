<?php

namespace Crm\SandboxBundle\Controller\Marketing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Crm\SandboxBundle\Entity\Channel;
use Crm\SandboxBundle\Form\ChannelType;
use Crm\SandboxBundle\Entity\SubChannel;
use Crm\SandboxBundle\Form\SubChannelType;

class CaseByOriginController extends Controller
{

    public function indexAction()
    {
    	$beginDate= new \DateTime('00-00-0000');
        $endDate= new \DateTime('now');
    	$caseByOriginReport = $this->get('crm.sandboxbundle.dealsManager')->getCaseByOrigin($beginDate,$endDate); 
    	return $this->render('CrmSandboxBundle:Marketing/CaseByOrigin:index.html.twig', array('caseByOriginReport' => $caseByOriginReport, ));
    }
    public function caseByOriginWidgetAction(Request $request)
    {
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');
        $smonth = $request->get('smonth');
        $emonth = $request->get('emonth');
        $syear = $request->get('syear');
        $eyear = $request->get('eyear');

        $currentBeginDate = new \DateTime($beginDate.'-'.$smonth.'-'.$syear);
        $currentEndDate = new \DateTime($endDate.'-'.$emonth.'-'.$eyear);

    	$caseByOriginReport = $this->get('crm.sandboxbundle.dealsManager')->getCaseByOrigin($currentBeginDate,$currentEndDate); 
    	return $this->render('CrmSandboxBundle:Marketing/CaseByOrigin:case-by-origin-widget.html.twig', array('caseByOriginReport' => $caseByOriginReport, ));
    }
    
}
