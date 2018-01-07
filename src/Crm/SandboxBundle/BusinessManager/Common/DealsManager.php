<?php
namespace Crm\SandboxBundle\BusinessManager\Common;

use Doctrine\ORM\EntityManager;
use Crm\SandboxBundle\Entity\Database;
use \DateTime;

class DealsManager 
{
	private $em;
	public function __construct(EntityManager $entityManager) 
	{
		$this->em = $entityManager;
	}
	public function getCaseByOrigin($beginDate,$endDate)
	{
		 return $caseByOrigin = $this->em->getRepository('CrmSandboxBundle:Deal')->getCaseByOrigin($beginDate,$endDate);
		 
	}

	public function getDealsSummaryByDate($beginning, $ending, $id, $type)
	{
		$deals = $this->em->getRepository('CrmSandboxBundle:Deal')->getDealsByDate($beginning, $ending, $id, $type);
		$result = [];
		$closedDealsValue = 0;
		$inProgressDealsValue = 0;
		$totalDealsValue = 0;
		foreach ($deals as $deal) {
			# Deal must be closed & approved in order to be considered closed.	
			if($deal->getClosed() && $deal->getApproved())	
				$closedDealsValue+= $deal->getPrice();
			else 
				$inProgressDealsValue+= $deal->getPrice();
		}
		$totalDealsValue = $closedDealsValue + $inProgressDealsValue;

		$result['closed'] = $closedDealsValue;
		$result['inProgress'] = $inProgressDealsValue;
		$result['total'] = $totalDealsValue;
		return $result;	
	}


}

?>