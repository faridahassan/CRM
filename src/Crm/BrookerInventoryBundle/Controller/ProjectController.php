<?php

namespace Crm\BrookerInventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Crm\BrookerInventoryBundle\Entity\Project;
use Crm\BrookerInventoryBundle\Form\FullProjectType;
use Crm\BrookerInventoryBundle\Form\ProjectType;
use Crm\BrookerInventoryBundle\Entity\Property;
use Crm\BrookerInventoryBundle\Entity\Location;
use Crm\BrookerInventoryBundle\Entity\Developer;
use Crm\BrookerInventoryBundle\Entity\Broker;
use Crm\BrookerInventoryBundle\Entity\PropertyType;
use Crm\BrookerInventoryBundle\Form\PropertyTypeType;
use Crm\SandboxBundle\Entity\Features;
use Crm\BrookerInventoryBundle\Form\LocationType;
use Crm\BrookerInventoryBundle\Form\DeveloperType;
use Crm\BrookerInventoryBundle\Form\BrokerType;
use Crm\SandboxBundle\Form\FeaturesType;

/**
 * Project controller.
 *
 */
class ProjectController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CrmBrookerInventoryBundle:Location')->findAll();
        

        
        //$entities = $qb->getQuery()->getResult();

        return $this->render('CrmBrookerInventoryBundle:Project:index.html.twig', array("entities" => $entities));
    }
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();


        $projects = $em->getRepository('CrmBrookerInventoryBundle:Project')->findAll();


        return $this->render('CrmBrookerInventoryBundle:Project:all.html.twig', ['projects' => $projects]);
    }

    /*
     * @ParamConverter("location", class="CrmBrookerInventoryBundle:Location")
     */
    public function projectVisitsAction(Location $location)
    {
        $em = $this->getDoctrine()->getManager();
    
        return $this->render('CrmBrookerInventoryBundle:Project:property_visits.html.twig', array('entities' => $location->getProperties()));
    }
    /*
     * @ParamConverter("property", class="CrmBrookerInventoryBundle:Property")
     */
    public function propertyVisitsBreakdownAction(Property $property)
    {

        return $this->render('CrmBrookerInventoryBundle:Project:property_breakdown.html.twig', array('visits' => $property->getVisits()));
    }
    public function manageAction()
    {

        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('CrmBrookerInventoryBundle:Location')->findAll();

        $locationDeleteForms = [];

        foreach ($locations as $location) {
            $locationDeleteForms[$location->getId()] = $this->createLocationDeleteForm($location->getId())->createView();
        }

        $developers = $em->getRepository('CrmBrookerInventoryBundle:Developer')->findAll();

        $developerDeleteForms = [];

        foreach ($developers as $developer) {
            $developerDeleteForms[$developer->getId()] = $this->createDeveloperDeleteForm($developer->getId())->createView();
        }

        $projects = $em->getRepository('CrmBrookerInventoryBundle:Project')->findAll();

        $projectDeleteForms = [];

        foreach ($projects as $project) {
            $projectDeleteForms[$project->getId()] = $this->createProjectDeleteForm($project->getId())->createView();
        }

        $features = $em->getRepository('CrmSandboxBundle:Features')->findAll();

        $featuresDeleteForms = [];

        foreach ($features as $feature) {
            $featuresDeleteForms[$feature->getId()] = $this->createFeaturesDeleteForm($feature->getId())->createView();
        }

        $brokers = $em->getRepository('CrmBrookerInventoryBundle:Broker')->findAll();

        $propertyTypes = $em->getRepository('CrmBrookerInventoryBundle:PropertyType')->findAll();

        $entity = new Location();
        $form   = $this->createLocationCreateForm($entity);

        $project = new Project();
        $projectForm = $this->createProjectCreateForm($project);

        $featureItem = new Features();
        $featureItemForm = $this->createFeatureCreateForm($featureItem);

        $developer = new Developer();
        $developerForm = $this->createDeveloperCreateForm($developer);
        
        $broker = new Broker();
        $brokerForm = $this->createBrokerCreateForm($broker);

        $propertyType = new PropertyType();
        $propertyTypeForm = $this->createPropertyTypeCreateForm($propertyType);

        return $this->render('CrmBrookerInventoryBundle:Project:manage.html.twig', array(
            'form'                => $form->createView(),
            'projectForm'         => $projectForm->createView(),
            'featureItemForm'     => $featureItemForm->createView(),
            'developerForm'       => $developerForm->createView(),
            'propertyTypeForm'    => $propertyTypeForm->createView(),
            'brokerForm'          => $brokerForm->createView(),
            'locations'           => $locations,
            'locationDeleteForms' => $locationDeleteForms,
            'projectDeleteForms'  => $projectDeleteForms,
            'featuresDeleteForms' => $featuresDeleteForms,
            'developerDeleteForms'=> $developerDeleteForms,
            'projects'            => $projects,
            'features'            => $features,
            'developers'          => $developers,
            'brokers'             => $brokers,
            'propertyTypes'       => $propertyTypes,

        ));
    }

    /**
     * Creates a form to create a Developer entity.
     *
     * @param Developer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBrokerCreateForm(Broker $entity)
    {
        $form = $this->createForm(new BrokerType(), $entity, array(
            'action' => $this->generateUrl('broker_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to delete a broker entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBrokerDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('broker_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

        /**
     * Creates a form to create a broker entity.
     *
     * @param Developer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeveloperCreateForm(Developer $entity)
    {
        $form = $this->createForm(new DeveloperType(), $entity, array(
            'action' => $this->generateUrl('developer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to delete a Developer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeveloperDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('developer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function updateLocationAjaxAction()
    {
        return true;   
    }

    /**
     * Creates a form to delete a Location entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLocationDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('location_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to create a Features entity.
     *
     * @param Features $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFeatureCreateForm(Features $entity)
    {
        $form = $this->createForm(new FeaturesType(), $entity, array(
            'action' => $this->generateUrl('features_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a Location entity.
     *
     * @param Location $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLocationCreateForm(Location $entity)
    {
        $form = $this->createForm(new LocationType(), $entity, array(
            'action' => $this->generateUrl('location_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    /**
     * Creates a new Project entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Project();
        $dir = $this->get('request')->getBasePath();
        $dir = substr($dir, 1);
        
        $form = $this->createFullProjectCreateForm($entity,$dir);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('notice', 'Project Created  successfully');
            return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getId())));
        }

        return $this->render('CrmBrookerInventoryBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function fullCreateAction(Request $request)
    {
        $entity = new Project();
        $form = $this->createFullProjectCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setFeatured(true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('project_all'));
        }

        return $this->render('CrmBrookerInventoryBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createProjectCreateForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, array(
            'action' => $this->generateUrl('project_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPropertyTypeCreateForm(PropertyType $entity)
    {
        $form = $this->createForm(new PropertyTypeType(), $entity, array(
            'action' => $this->generateUrl('propertytype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    private function createFullProjectCreateForm(Project $entity,$dir)
    {
        $form = $this->createForm(new FullProjectType($dir), $entity, array(
            'action' => $this->generateUrl('project_create'),

            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Project entity.
     *
     */
    public function newAction()
    {
        $entity = new Project();

        $dir = $this->get('request')->getBasePath();
        $dir = substr($dir, 1);
        

        $form   = $this->createFullProjectCreateForm($entity,$dir);


        return $this->render('CrmBrookerInventoryBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Project entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Project:show.html.twig', array(
            'project'      => $entity,
            // 'delete_form' => $deleteForm->createView(),
        ));
    }
    public function galleryAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Project:gallery.html.twig', array(
            'entity'      => $entity,
            // 'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $dir = $this->get('request')->getBasePath();
        $dir = substr($dir, 1);
        $editForm = $this->createFullEditForm($entity,$dir);

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('CrmBrookerInventoryBundle:Project:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Project entity.
    *
    * @param Project $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, array(
            'action' => $this->generateUrl('project_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    private function createFullEditForm(Project $entity,$dir)
    {
        $form = $this->createForm(new FullProjectType($dir), $entity, array(
            'action' => $this->generateUrl('project_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Project entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CrmBrookerInventoryBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $dir = $this->get('request')->getBasePath();
        $dir = substr($dir, 1);
        $editForm = $this->createFullEditForm($entity,$dir);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('notice', 'Project updated successfully');
            return $this->redirect($this->generateUrl('project_edit', array('id' => $id)));
        }

        return $this->render('CrmBrookerInventoryBundle:Project:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Project entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createProjectDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CrmBrookerInventoryBundle:Project')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Project entity.');
            }

            $em->remove($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventory_manage'));
        }

        return $this->redirect($this->generateUrl('project_edit', array('id' => $id)));
    }

    /**
     * Creates a form to delete a Features entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFeaturesDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('features_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a Project entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createProjectDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
