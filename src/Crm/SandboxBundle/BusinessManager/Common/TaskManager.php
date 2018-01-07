<?php
namespace Crm\SandboxBundle\BusinessManager\Common;

use Doctrine\ORM\EntityManager;
use Crm\SandboxBundle\Entity\Database;
use \DateTime;

class TaskManager 
{
	private $em;
	public function __construct(EntityManager $entityManager) 
	{
		$this->em = $entityManager;
	}
	public function getDailyDigest($user)
	{	
		$tasks = $this->em->getRepository('CrmSandboxBundle:Task')->getDailyTasks($user);	
		return $tasks;
	}


}

?>