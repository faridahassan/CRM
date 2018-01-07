<?php

namespace Crm\SandboxBundle\DAO;

use Crm\SandboxBundle\Entity\Database;
use Crm\SandboxBundle\Entity\Contact;

/**
 * DatabaseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DatabaseRepository extends \Doctrine\ORM\EntityRepository
{
	public function getDatabaseList()
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT d.id,d.name ,count( distinct l.id) as leads ,count(distinct co.id) as contacts ,count( distinct ca.id) as calls 
			from CrmSandboxBundle:Database d 
			left join d.contacts co 
			left join co.lead l
			left join l.calls ca
			group by d.name '
			);

		return $query->getResult();
	}
	public function findNextUser($database)
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT  c from CrmSandboxBundle:Contact c  left join c.database d where  d.id = :database and c.lead  is null and (c.mobile is not null or c.mobile2 is not null)'
			)->setMaxResults(1);
		$query ->setParameter('database',$database->getId());
		return $query->getSingleResult();
		
	}
}
