<?php
namespace Crm\MailingBundle\BusinessManager;
use Crm\NotificationBundle\BusinessManager\NotificationManager;
use Crm\BrookerInventoryBundle\Entity\Property;

class MailingManager 
{
	private $em;
	private $mailer;
	private $templating;
	private $notificationManager;
	private $taskManager;
	public function __construct($entityManager, $mailer, $templating,$notificationManager,$taskManager) 
	{
		$this->mailer = $mailer;
		$this->em = $entityManager;
		$this->templating = $templating;
		$this->notificationManager = $notificationManager;
		$this->taskManager= $taskManager;
	}

	public function sendEmail($subject,$user,$template,$object)
	{
		try {
			$message = \Swift_Message::newInstance()
			->setSubject($subject)
			->setFrom('georgesamy0@gmail.com')
			->setTo($user->getEmail())
			->setBody($this->templating->render($template, ['user'=>$user,'object'=>$object]),'text/html');
			$this->mailer->send($message);
			return " email sent successfully";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	
	
	public function sendPropertyEmail(Property $object,$user,$email,$name,$body,$subject){
		try {
			$message = \Swift_Message::newInstance()
			->setSubject($subject)
			->setFrom($user->getEmail())
			->setTo($email)
			->setBody($this->templating->render('Emails/Property/shareProperty.html.twig', ['user'=>$user,'object'=>$object,'name'=>$name,'body'=>$body]),'text/html');
			$this->mailer->send($message);	
			return "Email sent successfully.";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function sendDailyTasks()
	{
		$users = $this->em->getRepository('CrmSandboxBundle:User')->findAll();	
		foreach ($users as $user ) {
			$tasks = $this->taskManager->getDailyDigest($user);
			if ($tasks) {
				$this->sendEmail("CRM Daily Tasks",$user,'Emails/Notifications/dailyTasks.html.twig',$tasks);
			}
		}
		return "Emails Sent Successfully";
	}
	// sent at the end of the day.
	public function sendDealDigest(){
		try {
			$usersToNotify = $this->notificationManager->getAdminsSalesSalesRepresentatives();
			$notifications = $this->notificationManager->getDealDigestNotifications();
			foreach ($usersToNotify as $user) {
				$this->sendEmail("CRM Deal Digest",$user,'Emails/Notifications/dealsDigest.html.twig',$notifications);
			}
			$this->notificationManager->removeDealDigestNotifications();	
			return "Emails Sent Succesfully";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public function sendInventoryDigest(){
		try {
			$usersToNotify = $this->notificationManager->getAdminsSalesSalesRepresentatives();
			$notifications = $this->notificationManager->getInventoryDigestNotifications();
			if ($notifications) {
				foreach ($usersToNotify as $user) {
					$this->sendEmail("CRM Inventory Digest",$user,'Emails/Notifications/inventoryDigest.html.twig',$notifications);
				}
			}
	
			$this->notificationManager->removeInventoryDigestNotifications();	
			return "Emails Sent Succesfully";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public function sendLeadDigest(){
		try {
			$usersToNotify = $this->notificationManager->getAdminsSalesSalesRepresentatives();
			$notifications = $this->notificationManager->getDealDigestNotifications();
			foreach ($usersToNotify as $user) {
				$this->sendEmail("CRM Deal Digest",$user,'Emails/Notifications/leadDigest.html.twig',$notifications);
			}	
			return "Emails Sent Succesfully";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public function complaintDigest(){

	}
}