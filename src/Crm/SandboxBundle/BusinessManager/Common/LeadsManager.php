<?php
namespace Crm\SandboxBundle\BusinessManager\Common;
use Crm\NotificationBundle\BusinessManager\NotificationManager;

use Doctrine\ORM\EntityManager;
use Crm\SandboxBundle\Entity\Database;
use \DateTime;

class LeadsManager 
{
	private $em;
	private $notificationManager;
	public function __construct(EntityManager $entityManager, NotificationManager $notificationManager) 
	{
		$this->em = $entityManager;
		$this->notificationManager = $notificationManager;
	}
	public function getCaseByOrigin($beginDate,$endDate)
	{
		$caseByOrigin = $this->em->getRepository('CrmSandboxBundle:Lead')->getCaseByOrigin($beginDate,$endDate);
		return $caseByOrigin;
	}
	public function getLeadsByChannel($beginDate,$endDate)
	{
		
		$channels = $this->em->getRepository('CrmSandboxBundle:Channel')->findAll();
		$leadsByChannel = array();
		foreach ($channels as $channel) {
			$channelLeads = array($channel->getType() => $this->em->getRepository('CrmSandboxBundle:Lead')->getLeadsByChannel($channel->getType(),$beginDate,$endDate) );
			$leadsByChannel=array_merge($leadsByChannel,$channelLeads);
		}
		
		return $leadsByChannel;
	}


	public function addLeadToSystem($lead,$assignLeadTo,$userAssigning)
	{
		if($assignLeadTo == null)
		{
			$this->letSystemAssign($lead,$userAssigning,false);
		}
		else
		{
			if($assignLeadTo!=$userAssigning)
			{
				$this->notificationManager->leadNotification($lead,$assignLeadTo,$userAssigning);	
				$this->assignLeadToUser($lead,$assignLeadTo);
			}
			else
			{
				$this->assignLeadToMySelf($lead,$assignLeadTo);
			}

		}
	}

	public function assignLeadToMySelf($lead,$assignLeadTo)
	{

		if ($assignLeadTo->getRole() == "ROLE_SALES_REPRESENTATIVE") {
			$lead->setOwner($assignLeadTo->getTeam()->getleader());
			$lead->setTeam($assignLeadTo->getTeam());
			$lead->setAssignedSalesRep($assignLeadTo);
			$lead->setSalesRepAssignDate(new \DateTime('now'));
		}
		else
		{
			if ($assignLeadTo->getRole() == "ROLE_SALES_REPRESENTATIVE") {
				$lead->setOwner($assignLeadTo->getTeam()->getleader());
				$lead->setTeam($assignLeadTo->getTeam());
			}
			else{
				$lead->setOwner($assignLeadTo);		
				if ($assignLeadTo->getLedTeam()) {
					$lead->setTeam($assignLeadTo->getLedTeam());
				}
			}

		}
		$this->em->persist($lead);
		$this->em->persist($assignLeadTo);
		$this->em->flush();
	}
	public function assignLeadToUser($lead, $assignLeadTo)
	{	
		$role = $assignLeadTo->getRole();
		switch ($role) {
			case 'ROLE_SALES_REPRESENTATIVE':
			$lead->setAssignedSalesRep($assignLeadTo);
			$lead->setSalesRepAssignDate(new \DateTime('now'));
			$lead->setNew(true);
			$lead->setOwner($assignLeadTo->getTeam()->getleader());
			$lead->setTeam($assignLeadTo->getTeam());
			break;
			case 'ROLE_SALES_MANAGER':
			$lead->setAssignedSalesRep(null);
			$lead->setSalesRepAssignDate(new \DateTime('now'));
			$lead->setNew(true);
			$lead->setOwner($assignLeadTo);
			if ($assignLeadTo->getLedTeam()) {
				$lead->setTeam($assignLeadTo->getLedTeam());
			}
			break;
			case 'ROLE_ADMIN':
			$lead->setAssignedSalesRep(null);
			$lead->setSalesRepAssignDate(new \DateTime('now'));
			$lead->setNew(true);
			$lead->setOwner($assignLeadTo);
			break;
			case 'ROLE_ADMIN_SALES':
			$lead->setAssignedSalesRep(null);
			$lead->setSalesRepAssignDate(new \DateTime('now'));
			$lead->setNew(true);
			$lead->setOwner($assignLeadTo);
			break;
			default:
			return  "This user role cannot have leads.";
			break;
		}
		$this->em->persist($lead);
		$this->em->persist($assignLeadTo);

		$this->em->flush();
	}
	public function letSystemAssign($lead,$userAssigning,$includeMe){
		if ($userAssigning->getRole()=="ROLE_SALES_MANAGER") {
			$assignLeadTo = $this->em->getRepository('CrmSandboxBundle:User')->getUserLeadTurnInTeam("ROLE_SALES_REPRESENTATIVE",$userAssigning,$includeMe);
			$lead->setAssignedSalesRep($assignLeadTo);
			$lead->setOwner($userAssigning);
			if ($userAssigning->getLedTeam()) {
				$lead->setTeam($userAssigning->getLedTeam());
			}
			$lead->setSalesRepAssignDate(new \DateTime('now'));
			$lead->setNew(true);
			$assignLeadTo->setTakeLead(true);
		}
		else
		{
			$assignLeadTo = $this->em->getRepository('CrmSandboxBundle:User')->getUserLeadTurn("ROLE_SALES_MANAGER",$userAssigning);
			$teamShit = $assignLeadTo;
			$lead->setAssignedSalesRep(null);
			$lead->setOwner($assignLeadTo);
			$lead->setSalesRepAssignDate(new \DateTime('now'));
			$lead->setNew(true);
			$assignLeadTo->setTakeLead(true);
			
			
				
		}
		
		// here
		$this->notificationManager->leadNotification($lead,$assignLeadTo,$userAssigning);		
		$this->em->persist($assignLeadTo);
		$this->em->persist($lead);
		
		$this->em->flush();
	}
	
	public function shuffleLeads($user,$leads,$includeMe)
	{
		if($user->getRole()=="ROLE_SALES_MANAGER")
		{
			foreach ($leads as $lead) {
				$this->letSystemAssign($lead,$user,$includeMe);
			}
		}
		else
		{
			foreach ($leads as $lead) {
				$this->letSystemAssign($lead,$user,false);
			}	
		}
	}

}

?>