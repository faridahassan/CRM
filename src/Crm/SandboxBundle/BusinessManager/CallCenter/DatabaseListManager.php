<?php
namespace Crm\SandboxBundle\BusinessManager\CallCenter;

use Doctrine\ORM\EntityManager;
use Crm\SandboxBundle\Entity\Database;
use \DateTime;

class DatabaseListManager 
{
	private $em;
	public function __construct(EntityManager $entityManager) 
	{
		$this->em = $entityManager;

	}
	public function getDatabaseList()
	{
		
		return $this->em->getRepository('CrmSandboxBundle:Database')->getDatabaseList();
	}

	public function findNextUser($database)
	{
		return $this->em->getRepository('CrmSandboxBundle:Database')->findNextUser($database);	
	}
}

?>