<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Crm\BrookerInventoryBundle\Entity\Property;
use Crm\BrookerInventoryBundle\Entity\Project;
class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $homepageProperties = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['superFeatured' => true], ['propertyOrder' => 'ASC']);
        $featuredProperties = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['featured' => true], ['creationDate' => 'ASC']);

        // Calculat from featured instead
        $locations = $em->getRepository('CrmBrookerInventoryBundle:Location')->findAll();

        $locationsNames = [];

        foreach ($featuredProperties as $property) {
            # code...
            if ($property->getLocation()) {
                # code...
            
            $loc = $property->getLocation()->getName();
            if($loc)
            {
                if(!in_array($loc, $locationsNames))
                array_push($locationsNames, $loc);                
            }
        }

        }

        $form = $this->getFilterForm();

        return $this->render('WebsiteBundle:Page:index.html.twig', [
            'homepage_properties' => $homepageProperties,
            'featured_properties' => $featuredProperties,
            'locations'           => $locationsNames,
            'form'                => $form->createView(),
            ]);
    }
    public function propertiesAction(Request $request)
    {
        

        $form = $this->getFilterForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $filters = [];

            $location = $form->get('location')->getData();

            if($location)
                $filters['location'] = $location->getId();
            else
                unset($filters['location']);
            
            $area = $form->get('area')->getData();
            $area_exploded = explode(';',$area);
            $filters['min_area'] = $area_exploded[0];
            $filters['max_area'] = $area_exploded[1];
            if ($filters['min_area'] == 0 && $filters['max_area'] == 2000) {
                $filters['min_area'] = 1;
            } elseif ($filters['min_area'] == 0) {
                $filters['min_area'] = 1;
            } elseif ($filters['max_area'] == 10) {
                $filters['max_area'] = 1000000;
            }

            $landarea = $form->get('landarea')->getData();
            $area_exploded = explode(';',$landarea);
            $filters['min_landarea'] = $area_exploded[0];
            $filters['max_landarea'] = $area_exploded[1];
            if ($filters['min_landarea'] == 0 && $filters['max_landarea'] == 2000) {
                $filters['min_landarea'] = 1;
            } elseif ($filters['min_landarea'] == 0) {
                $filters['min_landarea'] = 1;
            } elseif ($filters['max_landarea'] == 10) {
                $filters['max_landarea'] = 1000000;
            }

            $rooms = $form->get('rooms')->getData();
            $rooms_expoloded = explode(';', $rooms);
            $filters['min_room'] = $rooms_expoloded[0];
            $filters['max_room'] = $rooms_expoloded[1];
            if ($filters['min_room'] == 0 && $filters['max_room'] == 10) {
                $filters['min_room'] = 1;
            } elseif ($filters['min_room'] == 0) {
                $filters['min_room'] = 1;
            } elseif ($filters['max_room'] == 10) {
                $filters['max_room'] = 1000000;
            }

            $contract_type = $form->get('contract_type')->getData();
            $filters['contract_type'] = $contract_type;
            


            $property_type = $form->get('property_type')->getData();
            if($property_type)
                $filters['property_type'] = $property_type;
            else
                unset($filters['property_type']);

            $project = $form->get('project')->getData();
            if($project)
                $filters['project'] = $project;
            else
                unset($filters['project']);

            $em = $this->getDoctrine()->getManager();


            // dump($filters);exit;
            $properties = $em->getRepository('CrmBrookerInventoryBundle:Property')->getPropertiesByFilter($filters);

        } else {
            $em = $this->getDoctrine()->getManager();
            $properties = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['featured' => true]);
        }


        return $this->render('WebsiteBundle:Page:property.html.twig', ['form' => $form->createView(), 'properties' => $properties]);
    }
    public function projectsAction()
    {
        return $this->render('WebsiteBundle:Page:projects.html.twig');
    }
       /**
     * @ParamConverter("project", class="CrmBrookerInventoryBundle:Project")
     */
     public function projectAction(Project $project , Request $request)
    {
         $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('WebsiteBundle_project' , array('project'=> $project->getId())))
        ->setMethod('POST')
        ->add('name', 'text', array('attr'=>array('required'=>'required')))
        ->add('email', 'email', array('attr'=>array('required'=>'required')))
        ->add('phone', 'text', array('attr'=>array('required'=>'required')))
        ->add('message', 'textarea', array('attr'=>array('required'=>'required')))
        ->add('submit', 'submit', array('label' => 'SUBMIT'))
        ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $message = \Swift_Message::newInstance()
            ->setSubject(''.$form->get('name')->getData() ."  ". $form->get('phone')->getData())
            ->setFrom($form->get('email')->getData())
            ->setTo('fhassanreda@gmail.com')
            ->setBody(''.$form->get('email')->getData().' '.$form->get('message')->getData());
            $this->addFlash('notice','Thank you, we will contact you soon!');
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('WebsiteBundle_project' , array('project'=> $project->getId())));
        }
        return $this->render('WebsiteBundle:Page:project.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            ]);
    }
    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('WebsiteBundle_contact'))
        ->setMethod('POST')
        ->add('name', 'text', array('attr'=>array('required'=>'required')))
        ->add('email', 'email', array('attr'=>array('required'=>'required')))
        ->add('phone', 'text', array('attr'=>array('required'=>'required')))
        ->add('message', 'textarea', array('attr'=>array('required'=>'required')))
        ->add('submit', 'submit', array('label' => 'SUBMIT'))
        ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $message = \Swift_Message::newInstance()
            ->setSubject(''.$form->get('name')->getData() ."  ". $form->get('phone')->getData())
            ->setFrom($form->get('email')->getData())
            ->setTo('fhassanreda@gmail.com')
            ->setBody(''.$form->get('email')->getData().' '.$form->get('message')->getData());
            $this->addFlash('notice','Thank you, we will contact you soon!');
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('WebsiteBundle_contact'));
        }
        return $this->render('WebsiteBundle:Page:contact.html.twig',array('form' => $form->createView(),));
    }
    /**
     * @ParamConverter("property", class="CrmBrookerInventoryBundle:Property")
     */
    public function property_detailsAction(Property $property)
    {  
        $form = $this->getFilterForm();

        $em = $this->getDoctrine()->getManager();
        $simillar="";
        //Get the number of rows from your table
        if ($property->getLocation()) {
        $rows = $em->createQuery(
            'SELECT COUNT(p.id) FROM CrmBrookerInventoryBundle:Property p where p.featured = true'
            )
            ->getSingleScalarResult();

        $amount = 3;
        $offset = max(0, rand(0, $rows - $amount - 1));
        $query = $em->createQuery(
            'SELECT p FROM CrmBrookerInventoryBundle:Property p join p.location l where p.featured = true  and l.id = :location'
            )
        
        ->setMaxResults($amount)
        ->setFirstResult($offset)
        ->setParameter('location',$property->getLocation())->getResult();
        

        }
        // dump($query);exit;
        return $this->render('WebsiteBundle:Page:property_details.html.twig', ['property' => $property, 'form' => $form->createView(),'simillar'=>$query]);
    }
    private function getFilterForm()
    {
        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('WebsiteBundle_properties'))
        ->add('contract_type', 'choice', [
            'choices' => [
            'Sale' => 'Buy',
            'Rent'  => 'Rent',
            'Both'  => 'Either',
            ],
            'required' => false,
            'empty_value' => 'Please select one',
            ])
            // GEEHINT: make sure the locations actually have featured properties
        ->add('location', 'entity', [
            'class' => 'CrmBrookerInventoryBundle:Location',
            'choice_label' => 'name',
                    // 'multiple' => true,
                    // 'expanded' => true
            'empty_value' => 'Please select one',
            'required' => false,
            ])
         ->add('project', 'entity', [
            'class' => 'CrmBrookerInventoryBundle:Project',
            'choice_label' => 'name',
                    // 'multiple' => true,
                    // 'expanded' => true
            'empty_value' => 'Please select one',
            'required' => false,
            ])
        ->add('property_type', 'entity', [
            'class' => 'CrmBrookerInventoryBundle:PropertyType',
            'choice_label' => 'name',
                    // 'multiple' => true,
                    // 'expanded' => true
            'empty_value' => 'Please select one',
            'required' => false,
            ])
        ->add('area', null, ['required' => false])
        ->add('landarea', null, ['required' => false])
        ->add('rooms', null, ['required' => false])
        ->add('submit', 'submit', ['label' => 'Search'])
        ->getForm();

        return $form;
    }
}