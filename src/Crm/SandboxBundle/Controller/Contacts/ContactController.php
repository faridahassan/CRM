<?php

namespace Crm\SandboxBundle\Controller\Contacts;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\SandboxBundle\Entity\Contact;
use Crm\SandboxBundle\Entity\Lead;
use Crm\BrookerInventoryBundle\Entity\Property;
use Crm\BrookerInventoryBundle\Entity\Location;
use Crm\BrookerInventoryBundle\Entity\Project;
use Crm\BrookerInventoryBundle\Entity\Developer;
use Crm\SandboxBundle\Entity\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function uploadExcelAction(Request $request)
    {
    	// $data = array();
	    $form = $this->createFormBuilder()
	        ->add('file', 'file')
            ->add('database_name', 'text')
	        ->add('submit', 'submit')
			->getForm();

		$form->handleRequest($request);

	    if ($form->isValid()) 
	    {
	        
            $databaseName = $form->get('database_name')->getData();

            $database = new Database();
            $database->setName($databaseName);

	        // $data is a simply array with your form fields 
	        // like "query" and "category" as defined above.
	        
	        $file = $form->get('file');
            

	        $actualFile = $file->getData();
	        $handle = fopen("$actualFile", "r");
	        $numberOfColumns;
            $firstIteration = true;
	        $em = $this->getDoctrine()->getManager();

            $unsavedContacts = [];
            $savedContacts = [];
            $saved = 0;

            $leadsManager = $this->get('crm.sandboxbundle.leadsManager');

	        while(($data = fgetcsv($handle, 5000, ",")) !== FALSE)
            {
                $nameBol = true; $mobile1Bol = true; $mobile2Bol = true;
                if($firstIteration){
                    $firstIteration = false;
                    continue;
                }

            	$name = $data[0];
                if ($name == "NULL" || !strlen($name)){
                    $nameBol = false;
                    $name = NULL;
                }
                
            	$address = $data[1];
                if ($address == "NULL" || !strlen($address))
                    $address = NULL;
                
            	$mobile1 = $data[2];
                if ($mobile1 == "NULL" || !strlen($mobile1)){
                    $mobile1Bol = false;
                    $mobile1 = NULL;
                }
                
            	$mobile2 = $data[3];
                if ($mobile2 == "NULL" || !strlen($mobile2)){
                    $mobile2Bol = false;
                    $mobile2 = NULL;
                }
                
            	$email = $data[4];
                if ($email == "NULL" || !strlen($email))
                    $email = NULL;

                // Check if phones exists before
                $all_with_mobiles = $em->getRepository('CrmSandboxBundle:Contact')->checkIfMobileExists($mobile1, $mobile2);

                // dump($all_with_mobiles);
                // if(($nameBol && ($mobile1Bol || $mobile2Bol) && !count($all_with_mobiles)) )
                //     echo '1';
                // else
                //     echo '0';

                // exit;

                if(($nameBol && ($mobile1Bol || $mobile2Bol) && !empty($all_with_mobiles)) )
                {
                    // Will not save
                    $row = [
                        'name' => $name,
                        'address' => $address,
                        'mobile1' => $mobile1,
                        'mobile2' => $mobile2,
                        'email' => $email
                    ];
                    $unsavedContacts[] = $row;
                }
                else {	
                	$contact = new Contact();
                	$contact->setName($name);
                	$contact->setAddress($address);
                	$contact->setMobile($mobile1);
                	$contact->setMobile2($mobile2);
                	$contact->setEmail($email);
                    $contact->setDatabase($database);
                    $database->addContact($contact);
                    
                    if($this->getUser()->hasRole('ROLE_SALES_REPRESENTATIVE') or $this->getUser()->hasRole("ROLE_SALES_MANAGER")) {
                        $lead = new Lead();
                        $lead->setContact($contact);
                        $contact->setLead($lead);
                        $em->persist($contact);
                        $em->persist($lead);
                        $leadsManager->assignLeadToMySelf($lead, $this->getUser());
                    }
                    $savedContacts[] = $contact;
                    $saved++;
                }
            }

            $em->persist($database);
            $em->flush();
	        
            return $this->render('CrmSandboxBundle:Contacts:progress.html.twig', ['saved' => $saved, 'unsavedContacts' => $unsavedContacts, 'savedContacts' => $savedContacts]);
	    }
        return $this->render('CrmSandboxBundle:Contacts:upload_excel.html.twig', array('form' => $form->createView()));
    }
    public function uploadInventoryExcelAction(Request $request)
    {
        // $data = array();
        $form = $this->createFormBuilder()
            ->add('file', 'file')
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) 
        {
            

            // $data is a simply array with your form fields 
            // like "query" and "category" as defined above.
            
            $file = $form->get('file');
            

            $actualFile = $file->getData();
            $handle = fopen("$actualFile", "r");
            $numberOfColumns;

            $em = $this->getDoctrine()->getManager();

            while(($data = fgetcsv($handle, 5000, ",")) !== FALSE)
            {
                $em = $this->getDoctrine()->getManager();
                $property = new Property();
                
                $location = $data[0];
                if (!strlen($location))
                    $location = NULL;
                else {
                    $locationEM = $em->getRepository('CrmBrookerInventoryBundle:Location')->findOneBy(['name' => $location]);
                    if(is_null($locationEM)){
                        $newLoc = new Location();
                        $newLoc->setName($location);
                        $property->setLocation($newLoc);
                        $em->persist($newLoc);
                    }
                    else
                        $property->setLocation($locationEM);
                }
                
                $project = $data[1];
                if (!strlen($project))
                    $project = NULL;
                else {
                    $projectEM = $em->getRepository('CrmBrookerInventoryBundle:Project')->findOneBy(['name' => $project]);
                    if(is_null($projectEM)){
                        $newProject = new Project();
                        $newProject->setName($project);
                        $property->setProject($newProject);
                        $em->persist($newProject);
                    }
                    else
                        $property->setProject($projectEM);
                }

                $Developer = $data[2];
                if (!strlen($Developer))
                    $Developer = NULL;
                else {
                    $DeveloperEM = $em->getRepository('CrmBrookerInventoryBundle:Developer')->findOneBy(['name' => $Developer]);
                    if(is_null($DeveloperEM)){
                        $newDeveloper = new Developer();
                        $newDeveloper->setName($Developer);
                        $property->setDeveloper($newDeveloper);
                        $em->persist($newDeveloper);
                    }
                    else
                        $property->setDeveloper($DeveloperEM);
                }

                $commercial = $data[3];
                if (!strlen($commercial))
                    $commercial = NULL;

                $name = $data[4];
                if (!strlen($name))
                    $name = NULL;
                $property->setName($name);

                $sellingType = $data[5];
                if (!strlen($sellingType))
                    $sellingType = NULL;
                $property->setSellingType($sellingType);

                $type = $data[6];
                if (!strlen($type))
                    $type = NULL;
                $property->setType($type);

                $propertyType = $data[7];
                if (!strlen($propertyType))
                    $propertyType = NULL;
                $property->setPropertyType($propertyType);
                
                $phase = $data[8];
                if (!strlen($phase))
                    $phase = NULL;
                $property->setPhase($phase);
                
                $address = $data[9];
                if (!strlen($address))
                    $address = NULL;
                $property->setAddress($address);

                $contactName = $data[10];
                if (!strlen($contactName))
                    $contactName = NULL;
                $property->setContactName($contactName);

                $ontactNumber = $data[11];
                if (!strlen($ontactNumber))
                    $ontactNumber = NULL;
                $property->setContactNumber($ontactNumber);

                $contactEmail = $data[12];
                if (!strlen($contactEmail))
                    $contactEmail = NULL;
                $property->setContactEmail($contactEmail);

                $contactAddress = $data[13];
                if (!strlen($contactAddress))
                    $contactAddress = NULL;
                $property->setContactAddress($contactAddress);

                $unitNumber = $data[14];
                if (!strlen($unitNumber))
                    $unitNumber = NULL;
                $property->setUnitNumber($unitNumber);
                
                $buildingNumber = $data[15];
                if (!strlen($buildingNumber))
                    $buildingNumber = NULL;
                $property->setBuildingNumber($buildingNumber);
                
                $landArea = $data[16];
                if (!strlen($landArea))
                    $landArea = NULL;
                $property->setLandArea(intval($landArea));

                $buildArea = $data[17];
                if (!strlen($buildArea))
                    $buildArea = NULL;
                $property->setBuildupArea(intval($buildArea));

                $gardenArea = $data[18];
                if (!strlen($gardenArea))
                    $gardenArea = NULL;
                $property->setGardenArea(intval($gardenArea));

                $numberOfFloors = $data[19];
                if (!strlen($numberOfFloors))
                    $numberOfFloors = NULL;
                $property->setFloors($numberOfFloors);

                $floorNumber = $data[20];
                if (!strlen($floorNumber))
                    $floorNumber = NULL;
                $property->setFloorNumber($floorNumber);

                $bathrooms = $data[21];
                if (!strlen($bathrooms))
                    $bathrooms = NULL;
                $property->setBathrooms($bathrooms);
                
                $bedrooms = $data[22];
                if (!strlen($bedrooms))
                    $bedrooms = NULL;
                $property->setBedrooms($bedrooms);
                
                $notes = $data[23];
                if (!strlen($notes))
                    $notes = NULL;
                $property->setNotes($notes);

                $askingPrice = $data[24];
                if (!strlen($askingPrice))
                    $askingPrice = NULL;
                $property->setAskingPrice(floatval($askingPrice));

                $originalPrice = $data[25];
                if (!strlen($originalPrice))
                    $originalPrice = NULL;
                $property->setOriginalPrice(floatval($originalPrice));

                $over = $data[26];
                if (!strlen($over))
                    $over = NULL;
                $property->setOver(floatval($over));

                $paid = $data[27];
                if (!strlen($paid))
                    $paid = NULL;
                $property->setPaid(floatval($paid));

                $transfer = $data[28];
                if (!strlen($transfer))
                    $transfer = NULL;
                $property->setTransfer(floatval($transfer));
                
                $maintenance = $data[29];
                if (!strlen($maintenance))
                    $maintenance = NULL;
                $property->setMaintenance(floatval($maintenance));
                
                $otherExpenses = $data[30];
                if (!strlen($otherExpenses))
                    $otherExpenses = NULL;
                $property->setOtherExpenses(floatval($otherExpenses));

                $buyerCommission = $data[31];
                if (!strlen($buyerCommission))
                    $buyerCommission = NULL;
                $property->setBuyerCommission(floatval($buyerCommission));

                $sellerCommission = $data[32];
                if (!strlen($sellerCommission))
                    $sellerCommission = NULL;
                $property->setSellerCommission(floatval($sellerCommission));

                $downPayment = $data[33];
                if (!strlen($downPayment))
                    $downPayment = NULL;
                $property->setDownPayment(floatval($downPayment));

                $totalPrice = $data[34];
                if (!strlen($totalPrice))
                    $totalPrice = NULL;
                $property->setTotalPrice(floatval($totalPrice));
                
                $remaining = $data[35];
                if (!strlen($remaining))
                    $remaining = NULL;
                $property->setRemaining($remaining);
            }
            $em->persist($property);
            $em->flush();
            
            echo "Success";
            return $this->redirect($this->generateUrl('inventory_inventory'));
        }
        return $this->render('CrmSandboxBundle:Contacts:inventory_upload_excel.html.twig', array('form' => $form->createView()));
    }
}
