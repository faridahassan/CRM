<?php

namespace Crm\AuditingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrmAuditingBundle:Default:index.html.twig', array('name' => $name));
    }
}
