<?php

namespace Crm\NotificationBundle\DAO;

use DoctrineExtensions\Query\Mysql\Day;

/**
 * LeadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PropertyNotificationRepository extends \Doctrine\ORM\EntityRepository
{
	public function getDigestReport()
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT  pn.type,count(pn) as number
			from CrmNotificationBundle:PropertyNotification  pn
			where pn.system = true
			and pn.seen = false
			group by  pn.type
			')
		;
		return ($query->getResult());
	}
	public function getDigestNotifications()
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT  pn
			from CrmNotificationBundle:PropertyNotification  pn
			where pn.system = true
			')
		;
		return ($query->getResult());
	}

}