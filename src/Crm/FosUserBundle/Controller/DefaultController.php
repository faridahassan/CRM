<?php

namespace Crm\FosUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CrmFosUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
