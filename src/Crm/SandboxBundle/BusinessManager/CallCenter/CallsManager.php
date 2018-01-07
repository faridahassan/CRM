<?php
namespace Crm\SandboxBundle\BusinessManager\CallCenter;

use Doctrine\ORM\EntityManager;
use Crm\SandboxBundle\Entity\Database;
use \DateTime;

class CallsManager 
{
	private $em;
	public function __construct(EntityManager $entityManager) 
	{
		$this->em = $entityManager;

	}
	public function getCallsOrientation($user)
	{

		$inbound = count($this->em->getRepository('CrmSandboxBundle:Call')->findby(array('orientation' => 'inbound','user'=> $user->getId())));
		$outbound = count($this->em->getRepository('CrmSandboxBundle:Call')->findby(array('orientation' => 'outbound','user'=>$user->getId())));
		$callRatio = array('inbound' => $inbound, 'outbound' => $outbound );
		return $callRatio;
	}
	public function getTotalCallsOrientation()
	{
		
		$inbound = count($this->em->getRepository('CrmSandboxBundle:Call')->findby(array('orientation' => 'inbound')));
		$outbound = count($this->em->getRepository('CrmSandboxBundle:Call')->findby(array('orientation' => 'outbound')));
		$callRatio = array('inbound' => $inbound, 'outbound' => $outbound );
		return $callRatio;		
	}

	public function getCallsBreakdown()
	{
		return $this->em->getRepository('CrmSandboxBundle:Call')->getCallsBreakdown();
	}


}

?>