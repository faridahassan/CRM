<?php

namespace Crm\SandboxBundle\Controller\Common;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CallsOrientationController extends Controller
{
    public function indexAction()
    {
  		$ratio = $this->get('crm.sandboxbundle.callsManager')->getCallsOrientation($this->getUser()); 
        return $this->render('CrmSandboxBundle:Common/LogAction:CallsOrientation.html.twig',array('ratio' => $ratio ));
    }
    public function totalCallsOrientationAction()
    {
    	$ratio = $this->get('crm.sandboxbundle.callsManager')->getTotalCallsOrientation(); 
    	return $this->render('CrmSandboxBundle:Common:CallsOrientation.html.twig',array('ratio' => $ratio ));
    }
}

 