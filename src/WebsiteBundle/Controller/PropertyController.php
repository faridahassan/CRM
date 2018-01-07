<?php

namespace WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PropertyController extends Controller
{
    public function managePropertyAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$entities = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['superFeatured' => true], ['propertyOrder' => 'ASC']);
        return $this->render('WebsiteBundle:Property:manageProperty.html.twig', array(
                // ...
        		'entities' => $entities
            )); 
    }

    public function updateOrderAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $ar = $request->request->get('order');

        foreach ($ar as $key => $value) {
            $pup = $em->getRepository('CrmBrookerInventoryBundle:Property')->find(intval($value));
            $pup->setPropertyOrder($key);
            $em->persist($pup);
        }
        $em->flush();
    	return new JsonResponse(['state' => 'success']);
    }

}
