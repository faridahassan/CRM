<?php
namespace Crm\NotificationBundle\BusinessManager;

use Crm\SandboxBundle\Entity\Lead;
use Crm\BrookerInventoryBundle\Entity\Property;
use Crm\SandboxBundle\Entity\Deal;
use Crm\SandboxBundle\Entity\User;
use Crm\MailingBundle\BusinessManager\MailingManager;
use Crm\NotificationBundle\Entity\LeadNotification;
use Crm\NotificationBundle\Entity\PropertyNotification;
use Crm\NotificationBundle\Entity\DealNotification;
use Doctrine\ORM\EntityManager;

class NotificationManager 
{
	private $em;
    public function __construct(EntityManager $entityManager) 
    {
        $this->em = $entityManager;
    }
    
    
    public function leadNotification(Lead $lead,User $user,User $userAssigning)
    {
        try {
            $notification = new LeadNotification();
            $notification->setType("Lead Notification");
            $notification->setText($userAssigning->getName(). " has assigned to you a new lead (". $lead->getContact()->getName() .")");
            $notification->setToUser($user);
            $notification->setLead($lead);
            $notification->setFromUser($userAssigning);
            $this->em->persist($notification);
            $this->em->flush();
            $notification = new LeadNotification();
            $notification->setType("Lead Notification");
            $notification->setText($userAssigning->getName(). " has assigned to you a new lead (". $lead->getContact()->getName() .")");
            $notification->setLead($lead);
            $notification->setSystem(true);
            $notification->setFromUser($userAssigning);
            $this->em->persist($notification);
            $this->em->flush();

        } catch (Exception $e) {
            return "Could not notifiy user" . $e->getMessage();
        }
    }
    public function dealNotification(Deal $deal,$type)
    {
        try {
            $users = $this->getAdminsSalesSalesRepresentatives();
            foreach ($users as $user) {
                $notification = new DealNotification();
                $notification->setType("Deal ".$type);
                $notification->setText("Has promoted your business");
                $notification->setToUser($user);
                if ($type!="Delete") {
                    $notification->setDeal($deal);
                }
                $this->em->persist($notification);
            }
            $notification = new DealNotification();
            $notification->setType("Deal ".$type);
            $notification->setText("Has promoted your business");
            $notification->setToUser($user);
            if ($type!="Delete") {
                $notification->setDeal($deal);
            }
            $notification->setToUser(NULL);
            $notification->setSystem(true);
            $this->em->persist($notification);
            $this->em->flush();
        } catch (Exception $e) {
            return "Could not notifiy user" . $e->getMessage();
        }
    }
    public function inventoryNotifiacation(Property $property, $new = false)
    {
        try {
            $users = $this->getAdminsSalesSalesRepresentatives();
            foreach ($users as $user) {
                $notification = new PropertyNotification();
                if (!$new) {
                    $notification->setType("Property Update");
                    $notification->setText("Has been updated");
                }
                else
                {
                    $notification->setType("Property Added");
                    $notification->setText("Has been added to the inventory");   
                }
                $notification->setProperty($property);
                $notification->setToUser($user);
                $this->em->persist($notification);
            }
            $notification = new PropertyNotification();
            if (!$new) {
                $notification->setType("Property Update");
                $notification->setText("Has been updated");
            }
            else
            {
                $notification->setType("Property Added");
                $notification->setText("Has been added to the inventory");   
            }
            $notification->setProperty($property);
            $notification->setToUser($user);
            $notification->setToUser(NULL);
            $notification->setSystem(true);
            $this->em->persist($notification);
            $this->em->flush();
        } catch (Exception $e) {
            return "Could not notifiy user" . $e->getMessage();
        }
    }
    // end notifications

    // retrieve digest and mark as seen
    public function getDealDigestNotifications()
     {
        return $notifications = $this->em->getRepository('CrmNotificationBundle:DealNotification')->getDigestReport();
    }
    public function removeDealDigestNotifications()
    {
        $notifications = $this->em->getRepository('CrmNotificationBundle:DealNotification')->getDigestNotifications();   
        foreach ($notifications as $notification) {
           $notification->setSeen(true);
           $this->em->persist($notification);
       }
       $this->em->flush();
    }
    public function getInventoryDigestNotifications()
     {
        return $notifications = $this->em->getRepository('CrmNotificationBundle:PropertyNotification')->getDigestReport();
    }
    public function removeInventoryDigestNotifications()
    {
        $notifications = $this->em->getRepository('CrmNotificationBundle:PropertyNotification')->getDigestNotifications();   
        foreach ($notifications as $notification) {
           $notification->setSeen(true);
           $this->em->persist($notification);
       }
       $this->em->flush();
    }
    public function getAdminsSalesSalesRepresentatives()
     {
        $admin = $this->em->getRepository('CrmSandboxBundle:User')->findByRole("ROLE_ADMIN");
        $salesManager = $this->em->getRepository('CrmSandboxBundle:User')->findByRole("ROLE_SALES");
        $salesReps = $this->em->getRepository('CrmSandboxBundle:User')->findByRole("ROLE_SALES_REPRESENTATIVE");
        $users = array_merge($admin,$salesManager,$salesReps);
        return $users;
    }
    ///

}