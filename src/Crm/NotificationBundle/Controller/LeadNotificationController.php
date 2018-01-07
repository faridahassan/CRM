<?php

namespace Crm\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeadNotificationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrmNotificationBundle:Default:index.html.twig', array('name' => $name));
    }
    public function markAllReadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CrmSandboxBundle:Lead')->getLeadNotifications($this->getUser());
        foreach ($entities as $entity) {
            $entity->setSeen(true);
            $em->persist($entity);
        }
           $em->flush();
        
        if ($this->getUser()->getRole() == "ROLE_SALES_REPRESENTATIVE") {
            return $this->redirect($this->generateUrl('sales_representative_assigned_leads'));
        }
        return $this->redirect($this->generateUrl('sales_assign_leads'));
    }
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CrmSandboxBundle:Lead')->getLeadNotifications($this->getUser());
        return $this->render('CrmNotificationBundle:LeadNotification:show.html.twig', array(
            'entities'      => $entities    
        ));
    }
}
