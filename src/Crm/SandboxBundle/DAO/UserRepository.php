<?php
namespace Crm\SandboxBundle\DAO;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
	 * @param string $role
	 *
	 * @return array
	 */
	public function findByRole($role)
	{
	    $qb = $this->_em->createQueryBuilder();
	    $qb ->select('u')
	        ->from($this->_entityName, 'u')
	        ->where('u.roles LIKE :roles')
	        ->setParameter('roles', '%"'.$role.'"%');

	    return $qb->getQuery()->getResult();
	}

	public function getNotifications($user)
	{
		$query = $this->getEntityManager()->createQuery(
			'SELECT l
			from CrmSandboxBundle:lead l
			where (l.user = :userId or  l.assignedSalesRep = :userId)
			 and  l.isLead = 1	
			 and  l.closedStatus IS NULL
			'
			)
			->setParameter('userId', $userId);
			return ($query->getResult());	
	}

	public function getUserLeadTurn($role,$userAssigning)
	{
		$query = $this->getEntityManager()->createQuery(
			"SELECT u
			from CrmSandboxBundle:User u

			where u.roles LIKE :roles
			and  u.takeLead = false
			"
			)
			->setParameter('roles', '%"'.$role.'"%')
			->setMaxResults(1);
		 $result =  $query->getOneOrNullResult();	
		 
		 if ($result == null)
		 {
		 	 $query = $this->getEntityManager()->createQuery("UPDATE CrmSandboxBundle:User u SET u.takeLead = false where u.roles LIKE :roles")->setParameter('roles', '%"'.$role.'"%');
		 	 $query->getResult();
		 	 return $this->getUserLeadTurn($role,$userAssigning);
		 }
		 return $result;
	}
	public function getUserLeadTurnInTeam($role,$userAssigning,$includeMe)
	{
		$teamId= $userAssigning->getLedTeam()->getId();
		$query = $this->getEntityManager()->createQuery(
			"SELECT u
			from CrmSandboxBundle:User u
			where u.roles LIKE :roles
			and  u.team =:teamId
			and  u.takeLead = false
			"
			)
			->setParameter('roles', '%"'.$role.'"%')
			->setParameter('teamId', $teamId)
			->setMaxResults(1);
		 $result =  $query->getOneOrNullResult();	
		 if ($result == null)
		 {
		 	 $query = $this->getEntityManager()->createQuery("UPDATE CrmSandboxBundle:User u SET u.takeLead = false where u.roles LIKE :roles and u.team =:teamId")->setParameter('roles', '%"'.$role.'"%')->setParameter('teamId', $teamId);
		 	 $query->getResult();
		 	 if($includeMe)
		 	 	return $userAssigning;
		 	 return $this->getUserLeadTurn($role,$userAssigning,$includeMe);
		 }
		 return $result;
	}

}