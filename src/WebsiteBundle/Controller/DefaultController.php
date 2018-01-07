<?php

namespace WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
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
            $loc = $property->getLocation()->getName();
            if(!in_array($loc, $locationsNames))
                array_push($locationsNames, $loc);
        }


        return $this->render('WebsiteBundle:Default:index.html.twig', [
            'homepage_properties' => $homepageProperties,
            'featured_properties' => $featuredProperties,
            'locations'           => $locationsNames
            ]);
    }
    public function aboutAction()
    {
        return $this->render('WebsiteBundle:Default:about.html.twig');
    }
    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('website_contact'))
        ->setMethod('POST')
        ->add('name', 'text')
        ->add('email', 'email')
        ->add('phone', 'text')
        ->add('subject', 'text')
        ->add('message', 'textarea')
        ->add('submit', 'submit', array('label' => 'SUBMIT'))
        ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
             $message = \Swift_Message::newInstance()
            ->setSubject(''.$form->get('subject')->getData() ."  ". $form->get('phone')->getData())
            ->setFrom($form->get('email')->getData())
            ->setTo('georgesamy0@gmail.com')
            ->setBody(''.$form->get('email')->getData().' '.$form->get('message')->getData());
            $this->addFlash('notice','Thank you, we will contact you soon!');
            $this->get('mailer')->send($message);
            
            return $this->redirect($this->generateUrl('website_contact'));

        }

        return $this->render('WebsiteBundle:Default:contact.html.twig',['form'=>$form->CreateView()]);
    }
    public function propertiesAction($location)
    {
        $location_id = 0;
        $em = $this->getDoctrine()->getManager();
        $location;
        if($location){
            $location_id = $em->getRepository('CrmBrookerInventoryBundle:Location')->findOneBy(['name' => $location])->getId();
        }

        $homepageProperties = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['superFeatured' => true], ['propertyOrder' => 'ASC']); 

        $featuredProperties;
        if($location_id) {

            $featuredProperties = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['featured' => true, 'location' => $location_id], ['creationDate' => 'ASC']);
            dump($featuredProperties);
            exit;
        }
        else {
            $featuredProperties = $em->getRepository('CrmBrookerInventoryBundle:Property')->findBy(['featured' => true], ['creationDate' => 'ASC']);
        }

        // dump($featuredProperties);
        // exit;
        return $this->render('WebsiteBundle:Default:properties.html.twig', ['homepage_properties' => $homepageProperties, 'featured_properties' => $featuredProperties]);
    }
    public function propertyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $property = $em->getRepository('CrmBrookerInventoryBundle:Property')->find($id);

        return $this->render('WebsiteBundle:Default:property.html.twig', ['property' => $property]);
    }
    public function sellPropertyAction(Request $request)
    {
         $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('website_contact'))
        ->setMethod('POST')
        ->add('name', 'text')
        ->add('email', 'email')
        ->add('phone', 'text')
        ->add('subject', 'text')
        ->add('message', 'textarea')
        ->add('submit', 'submit', array('label' => 'SUBMIT'))
        ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
             $message = \Swift_Message::newInstance()
            ->setSubject(''.$form->get('subject')->getData() ."  ". $form->get('phone')->getData())
            ->setFrom($form->get('email')->getData())
            ->setTo('georgesamy0@gmail.com')
            ->setBody(''.$form->get('email')->getData().' '.$form->get('message')->getData());
            $this->addFlash('notice','Thank you, we will contact you soon!');
            $this->get('mailer')->send($message);
            
            return $this->redirect($this->generateUrl('website_contact'));

        }

        return $this->render('WebsiteBundle:Default:sellProperty.html.twig',['form'=>$form->CreateView()]);
    }
}
