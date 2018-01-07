<?php

namespace Crm\SandboxBundle\Controller\Sales;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\SandboxBundle\Entity\Deal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

class DealsController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $deals = $em->getRepository('CrmSandboxBundle:Deal')->getUserOrAllDealsAndOrderByDate();
        $deleteForms=[];
    	foreach ($deals as $deal) {
            $deleteForms[$deal->getId()] = $this->createDeleteForm($deal->getId())->createView();
        }
        return $this->render('CrmSandboxBundle:Sales/Deals:index.html.twig',array('deals' => $deals,'deleteForms'=>$deleteForms));
    }
    /**
     * @ParamConverter("deal", class="CrmSandboxBundle:Deal")
     */
    public function approveAction(Deal $deal)
    {
    	$em = $this->getDoctrine()->getManager();
    	$deal->setApproved(true);
        $property = $deal->getProperty();
        $property->setIsSold(true);
        $lead = $deal->getLead();
        if (!is_null($lead))
            $lead->setClosedStatus(0);
        $em->persist($property);
    	$em->persist($deal);
    	$em->flush();
    	$em = $this->getDoctrine()->getManager();
    	
        $this->get('crm.notificationBundle.notificationManager')->dealNotification($deal,"Approve");
		return $this->redirectToRoute('sales_deals');
    }
    /**
     * @ParamConverter("deal", class="CrmSandboxBundle:Deal")
     */
    public function disapproveAction(Deal $deal)
    {
    	$em = $this->getDoctrine()->getManager();
    	$deal->setApproved(false);
    	$em->persist($deal);
    	$em->flush();
    	
        $this->get('crm.notificationBundle.notificationManager')->dealNotification($deal,"Disapprove");
		return $this->redirectToRoute('sales_deals');
    }
    /**
     * @ParamConverter("deal", class="CrmSandboxBundle:Deal")
     */
    public function closeAction(Deal $deal)
    {
        $em = $this->getDoctrine()->getManager();
        $deal->setClosed(true);
        $deal->setClosedDate(new \DateTime('now'));
        $em->persist($deal);
        $em->flush();
        $this->get('crm.notificationBundle.notificationManager')->dealNotification($deal,"Close");
        if ($this->getUser()->hasRole('ROLE_SALES_REPRESENTATIVE'))
            return $this->redirectToRoute('sales_representative_deals');     
        return $this->redirectToRoute('sales_deals');
    }
    /**
     * @ParamConverter("deal", class="CrmSandboxBundle:Deal")
     */
    public function showAction(Deal $deal)
    {
        $deleteForm = $this->createDeleteForm($deal->getId());
    	return $this->render('CrmSandboxBundle:Sales/Deals:show.html.twig',array('deal' => $deal,'delete_form' => $deleteForm->createView()));
    }
    /**
     * Creates a form to delete a Deal entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deal_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
