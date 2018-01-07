<?php

namespace Crm\SandboxBundle\Controller\Sales;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

class SMApplicationsController extends Controller
{
    public function indexAction()
    {

        return $this->render('CrmSandboxBundle:Sales/SMApplications:index.html.twig');
    }
}
