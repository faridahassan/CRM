<?php

namespace Crm\BrookerInventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Property controller.
 *
 */
class InventoryController extends Controller
{

    /**
     * Lists all Property entities.
     *
     */
    public function indexAction($sold)
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('CrmBrookerInventoryBundle:Location')->findAll();

        $sales_representatives = $em->getRepository('CrmSandboxBundle:User')->findByRole('ROLE_SALES_REPRESENTATIVE');

        $entities = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['isSold' => $sold ], ['creationDate' => 'DESC']);
        
        $contacts = [];
        foreach ($entities as $entity) {
            $curName = $entity->getContactName();
            if(!in_array($curName, $contacts))
                array_push($contacts, $curName);
        }
        return $this->render('CrmBrookerInventoryBundle:Inventory:index.html.twig', array(
            'entities'  => $entities,
            'locations' => $locations,
            'contacts'  => $contacts,
            'sales_reps' => $sales_representatives
            ));
    }
}
