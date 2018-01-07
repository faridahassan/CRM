<?php

namespace Crm\SandboxBundle\Controller\SalesRepresentative;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Crm\SandboxBundle\Entity\Deal;
use Crm\BrookerInventoryBundle\Entity\Property;
use Crm\SandboxBundle\Form\DealType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

class DealsController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $deals;
        if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_SALES_MANAGER') ) {
            $deals = $em->getRepository('CrmSandboxBundle:Deal')->getUserOrAllDealsAndOrderByDate();
        }
        else {
            $deals = $em->getRepository('CrmSandboxBundle:Deal')->getUserOrAllDealsAndOrderByDate($this->getUser()->getId());
        }

        return $this->render('CrmSandboxBundle:Sales/Deals:index.html.twig', array('deals' => $deals));
    }
    public function newAction()
    {
    	$entity = new Deal();
        $entity->setClosed(false);
        $form   = $this->createCreateForm($entity);

        return $this->render('CrmSandboxBundle:Sales/Deals:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * @ParamConverter("property", class="CrmBrookerInventoryBundle:Property")
     */
    public function updatePropertyPriceAction(Property $property)
    {
        $commission = $property->getSellerCommission() + $property->getBuyerCommission();
        return new JsonResponse(['price' => $property->getTotalPrice(), 'commission' => $commission]);
    }
    private function createCreateForm(Deal $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new DealType($em), $entity, array(
            'action' => $this->generateUrl('deal_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
