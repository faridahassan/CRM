<?php

namespace Crm\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrmMailingBundle:Default:index.html.twig', array('name' => $name));
    }
}
