<?php

namespace Crm\BrookerInventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

use Crm\BrookerInventoryBundle\Entity\Property;
use Crm\SandboxBundle\Entity\Features;
use Crm\BrookerInventoryBundle\Form\PropertyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Property controller.
 *
 */
class PropertyController extends Controller

{
    public function historyAction($propertyId)
    {

        $reader = $this->get('crm.auditingbundle.auditTransformer');
        $history = $reader->getHistory('Crm\BrookerInventoryBundle\Entity\Property', $propertyId);

        return $this->render('CrmBrookerInventoryBundle:Property:history.html.twig', $history);
    }

    /**
     * Lists all Property entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmBrookerInventoryBundle:Property')->findAll();

        return $this->render('CrmBrookerInventoryBundle:Property:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * @ParamConverter("property", class="CrmBrookerInventoryBundle:Property")
     */
    public function soldAction(Property $property, $isSell)
    {
        $em = $this->getDoctrine()->getManager();
        if(intval($isSell))
        {
            $property->setIsSold(true);
            $this->get('crm.notificationBundle.notificationManager')->inventoryNotifiacation($entity,true);
        }
        else 
            $property->setIsSold(false);
        $em->persist($property);
        $em->flush();
        return new JsonResponse(array('hi'=>'hi'));
    }

    /**
     * Creates a new Property entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Property();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedBy($this->getUser());
            $em->persist($entity);
            $em->flush();
            $this->get('crm.notificationBundle.notificationManager')->inventoryNotifiacation($entity,true);
            $session = new Session();
            $session->getFlashBag()->add('notice', 'Property Added successfully.');
            return $this->redirect($this->generateUrl('inventory_inventory'));
        }

        return $this->render('CrmBrookerInventoryBundle:Property:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Property entity.
     *
     * @param Property $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Property $entity)
    {
        $form = $this->createForm(new PropertyType(), $entity, array(
            'action' => $this->generateUrl('property_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Property entity.
     *
     */
    public function newAction()
    {
        $entity = new Property();

        $features = new Features();

        $em = $this->getDoctrine()->getManager();
        $featureItems = $em->getRepository('CrmSandboxBundle:FeatureItem')->findAll();
        $feature;

        $form   = $this->createCreateForm($entity);

        return $this->render('CrmBrookerInventoryBundle:Property:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Property entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Property entity.');
        }


        // Only admins and people who entered the property can edit it.
        $canSee = false;
        if ($entity->getCreatedBy() == $this->getUser())
            $canSee = true;

        $reader = $this->get('crm.auditingbundle.auditTransformer');
        $has_history = $reader->hasHistory('Crm\BrookerInventoryBundle\Entity\Property', $id);


        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Property:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'canSee'      => $canSee,
            'hasHistory'  => $has_history
        ));
    }
    public function showGalleryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Property entity.');
        }
        return $this->render('CrmBrookerInventoryBundle:Property:gallery.html.twig', array('entity' => $entity,));
    }

    /**
     * Displays a form to edit an existing Property entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Property entity.');
        }

        // Only admins and people who entered the property can edit it.
        $canEdit = false;
        if ($entity->getCreatedBy() == $this->getUser())
            $canEdit = true;

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Property:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'canEdit' => $canEdit
        ));
    }

    /**
    * Creates a form to edit a Property entity.
    *
    * @param Property $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Property $entity)
    {
        $form = $this->createForm(new PropertyType(), $entity, array(
            'action' => $this->generateUrl('property_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Property entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Property entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $entity->setUpdateDate(new \DateTime('now'));
            $entity->setUpdatedBy($this->getUser());
            $em->persist($entity);
            $em->flush();
            $this->get('crm.notificationBundle.notificationManager')->inventoryNotifiacation($entity,false);

            $session = new Session();
            $session->getFlashBag()->add('notice', 'Property Updated successfully.');

            return $this->redirect($this->generateUrl('inventory_inventory'));
        }

        // Only admins and people who entered the property can edit it.
        $canEdit = false;
        if ($entity->getCreatedBy() == $this->getUser())
            $canEdit = true;

        return $this->render('CrmBrookerInventoryBundle:Property:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'canEdit' => $canEdit,
        ));
    }
    /**
     * Deletes a Property entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Property entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('property'));
    }
    public function removeFromSliderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $property=$em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);
        $property->setSuperFeatured(false);
        $em->persist($property);
        $em->flush();
        $entities = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['superFeatured' => true], ['propertyOrder' => 'ASC']);
        return $this->render('WebsiteBundle:Property:manageProperty.html.twig', array('entities' => $entities)); 

    }
    /**
     * Creates a form to delete a Property entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('property_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function sendPropertyEmailAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $name = $request->get('name');
            $subject = $request->get('subject');
            $email = $request->get('email');
            $body = $request->get('body');
            $id = $request->get('property');
            $user = $this->getUser();
            $entity = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Property entity.');
            }
            return new JsonResponse($this->get('crm.mailingBundle.mailingManager')->sendPropertyEmail($entity,$user,$email,$name,$body,$subject));
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        
    }
}
