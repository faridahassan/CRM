<?php

namespace Crm\SandboxBundle\Controller\CallCenter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Crm\SandboxBundle\Entity\Database;
use Crm\SandboxBundle\Entity\Contact;
use Crm\SandboxBundle\Entity\Lead;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DatabaseListController extends Controller
{
	public function indexAction()
	{
		$databases = $this->get('crm.sandboxbundle.databaseListManager')->getDatabaseList(); 
		dump($databases);exit;

		return $this->render('CrmSandboxBundle:CallCenter\DatabaseList:index.html.twig', array('databases' => $databases));
	}

	public function uploadDatabaseAction()
	{
		return $this->render('CrmSandboxBundle:CallCenter\DatabaseList:upload.html.twig');	
	}

	/**
	 * @ParamConverter("database", class="CrmSandboxBundle:Database")
	 */
	public function findNextUserAction(Database $database)
	{
		$contact  = $this->get('crm.sandboxbundle.databaseListManager')->findNextUser($database); 

		$lead = new Lead();
		$contact->setLead($lead);
		$lead->setUser($this->getUser());
		$lead->setContact($contact);
		$em = $this->getDoctrine()->getManager();
		$em->persist($lead);
		$em->persist($contact);
		$this->get('crm.sandboxbundle.leadsManager')->addLeadToSystem($lead,$this->getUser(),$this->getUser());
		$em->flush();
		return $this->redirect($this->generateUrl('callcenter_log_outbound_call',array('id' => $lead->getId(), 'orientation' => 1 )));
	}
}
