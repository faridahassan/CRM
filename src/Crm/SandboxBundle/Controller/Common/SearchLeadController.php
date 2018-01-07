<?php

namespace Crm\SandboxBundle\Controller\Common;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Crm\SandboxBundle\Entity\Call;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Form\CallType;
use Crm\SandboxBundle\Form\LeadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SearchLeadController extends Controller
{
    public function indexAction()
    {
        return $this->render('CrmSandboxBundle:Common:find_leads.html.twig'); 
    }
}
