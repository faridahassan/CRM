<?php

namespace Crm\BrookerInventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Project
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="string", length=255, nullable=true)
     */
    private $slogan;

    /**
     * @ORM\Column(name="landArea", type="string", length=100, nullable=true)
     */
    private $landArea;

    /**
     * @ORM\Column(name="number_of_units", type="integer", nullable=true)
     */
    private $numberOfUnits;

    /**
     * @ORM\Column(name="unit_types", type="string", nullable=true)
     */
    private $unitTypes;

    /**
     * @ORM\Column(name="average_price", type="integer", nullable=true)
     */
    private $averagePrice;

    /**
     * @ORM\Column(name="project_built_density", type="integer", nullable=true)
     */
    private $projectBuiltDensity;

    /**
     * @ORM\Column(name="max_height", type="integer", nullable=true)
     */
    private $maxHeight;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="amenities", type="text", nullable=true)
     */
    private $amenities;

    /**
     * @ORM\Column(name="finishing", type="string", nullable=true)
     */
    private $finishing;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(name="gps_coordinates", type="string", nullable=true)
     */
    private $gpsCoordinates;

    /**
     * @ORM\Column(name="land_marks", type="string", nullable=true)
     */
    private $landMarks;

    /**
     * @ORM\Column(name="number_of_phases", type="integer", nullable=true)
     */
    private $numberOfPhases;

    /**
     * @ORM\Column(name="next_delivery_by", type="datetime", nullable=true)
     */
    private $nextDeliveryBy;


    /**
     * @ORM\Column(name="payment_plans", type="string", nullable=true)
     */
    private $paymentPlans;

    /**
     * @ORM\Column(name="current_phase", type="string", nullable=true)
     */
    private $currentPhase;

    /**
     * @ORM\Column(type="array", nullable=true, length=10000, nullable=true)
     */
    private $gallery;
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $slider;

    /**
     * @ORM\Column(name="master_plan", type="string", nullable=true)
     */
    private $masterPlan;

    /**
     * @ORM\Column(name="prime_available", type="boolean", nullable=true)
     */
    private $primeAvailable;

    /**
     * @ORM\Column(name="featured", type="boolean", nullable=true)
     */
    private $featured = false;

    /**
     * @ORM\OneToMany(targetEntity="Property", mappedBy="project")
     */
    private $properties;

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="projects")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="Developer", inversedBy="projects")
     */
    private $developer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $folder;

    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'images/projects/'.$this->getFolder();
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : '/'.$this->getUploadDir().'/'.$this->image;
    }

    public function __construct()
    {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->folder = $this->generateRandomString();
    }

    public function generateRandomString() {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add property
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $property
     *
     * @return Project
     */
    public function addProperty(\Crm\BrookerInventoryBundle\Entity\Property $property)
    {
        $this->properties[] = $property;

        return $this;
    }

    /**
     * Remove property
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $property
     */
    public function removeProperty(\Crm\BrookerInventoryBundle\Entity\Property $property)
    {
        $this->properties->removeElement($property);
    }

    /**
     * Get properties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set location
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Location $location
     * @return Project
     */
    public function setLocation(\Crm\BrookerInventoryBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set developer
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Developer $developer
     * @return Project
     */
    public function setDeveloper(\Crm\BrookerInventoryBundle\Entity\Developer $developer = null)
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * Get developer
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Developer 
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     * @return Project
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string 
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set landArea
     *
     * @param string $landArea
     * @return Project
     */
    public function setLandArea($landArea)
    {
        $this->landArea = $landArea;

        return $this;
    }

    /**
     * Get landArea
     *
     * @return string 
     */
    public function getLandArea()
    {
        return $this->landArea;
    }

    /**
     * Set numberOfUnits
     *
     * @param integer $numberOfUnits
     * @return Project
     */
    public function setNumberOfUnits($numberOfUnits)
    {
        $this->numberOfUnits = $numberOfUnits;

        return $this;
    }

    /**
     * Get numberOfUnits
     *
     * @return integer 
     */
    public function getNumberOfUnits()
    {
        return $this->numberOfUnits;
    }

    /**
     * Set unitTypes
     *
     * @param string $unitTypes
     * @return Project
     */
    public function setUnitTypes($unitTypes)
    {
        $this->unitTypes = $unitTypes;

        return $this;
    }

    /**
     * Get unitTypes
     *
     * @return string 
     */
    public function getUnitTypes()
    {
        return $this->unitTypes;
    }

    /**
     * Set averagePrice
     *
     * @param integer $averagePrice
     * @return Project
     */
    public function setAveragePrice($averagePrice)
    {
        $this->averagePrice = $averagePrice;

        return $this;
    }

    /**
     * Get averagePrice
     *
     * @return integer 
     */
    public function getAveragePrice()
    {
        return $this->averagePrice;
    }

    /**
     * Set projectBuiltDensity
     *
     * @param integer $projectBuiltDensity
     * @return Project
     */
    public function setProjectBuiltDensity($projectBuiltDensity)
    {
        $this->projectBuiltDensity = $projectBuiltDensity;

        return $this;
    }

    /**
     * Get projectBuiltDensity
     *
     * @return integer 
     */
    public function getProjectBuiltDensity()
    {
        return $this->projectBuiltDensity;
    }

    /**
     * Set maxHeight
     *
     * @param integer $maxHeight
     * @return Project
     */
    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    /**
     * Get maxHeight
     *
     * @return integer 
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set amenities
     *
     * @param string $amenities
     * @return Project
     */
    public function setAmenities($amenities)
    {
        $this->amenities = $amenities;

        return $this;
    }

    /**
     * Get amenities
     *
     * @return string 
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Set finishing
     *
     * @param string $finishing
     * @return Project
     */
    public function setFinishing($finishing)
    {
        $this->finishing = $finishing;

        return $this;
    }

    /**
     * Get finishing
     *
     * @return string 
     */
    public function getFinishing()
    {
        return $this->finishing;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Project
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set gpsCoordinates
     *
     * @param string $gpsCoordinates
     * @return Project
     */
    public function setGpsCoordinates($gpsCoordinates)
    {
        $this->gpsCoordinates = $gpsCoordinates;

        return $this;
    }

    /**
     * Get gpsCoordinates
     *
     * @return string 
     */
    public function getGpsCoordinates()
    {
        return $this->gpsCoordinates;
    }

    /**
     * Set landMarks
     *
     * @param string $landMarks
     * @return Project
     */
    public function setLandMarks($landMarks)
    {
        $this->landMarks = $landMarks;

        return $this;
    }

    /**
     * Get landMarks
     *
     * @return string 
     */
    public function getLandMarks()
    {
        return $this->landMarks;
    }

    /**
     * Set numberOfPhases
     *
     * @param integer $numberOfPhases
     * @return Project
     */
    public function setNumberOfPhases($numberOfPhases)
    {
        $this->numberOfPhases = $numberOfPhases;

        return $this;
    }

    /**
     * Get numberOfPhases
     *
     * @return integer 
     */
    public function getNumberOfPhases()
    {
        return $this->numberOfPhases;
    }

    /**
     * Set nextDeliveryBy
     *
     * @param \DateTime $nextDeliveryBy
     * @return Project
     */
    public function setNextDeliveryBy($nextDeliveryBy)
    {
        $this->nextDeliveryBy = $nextDeliveryBy;

        return $this;
    }

    /**
     * Get nextDeliveryBy
     *
     * @return \DateTime 
     */
    public function getNextDeliveryBy()
    {
        return $this->nextDeliveryBy;
    }

    /**
     * Set paymentPlans
     *
     * @param string $paymentPlans
     * @return Project
     */
    public function setPaymentPlans($paymentPlans)
    {
        $this->paymentPlans = $paymentPlans;

        return $this;
    }

    /**
     * Get paymentPlans
     *
     * @return string 
     */
    public function getPaymentPlans()
    {
        return $this->paymentPlans;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     * @return Project
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return array 
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set masterPlan
     *
     * @param string $masterPlan
     * @return Project
     */
    public function setMasterPlan($masterPlan)
    {
        $this->masterPlan = $masterPlan;

        return $this;
    }

    /**
     * Get masterPlan
     *
     * @return string 
     */
    public function getMasterPlan()
    {
        return $this->masterPlan;
    }

    /**
     * Set primeAvailable
     *
     * @param boolean $primeAvailable
     * @return Project
     */
    public function setPrimeAvailable($primeAvailable)
    {
        $this->primeAvailable = $primeAvailable;

        return $this;
    }

    /**
     * Get primeAvailable
     *
     * @return boolean 
     */
    public function getPrimeAvailable()
    {
        return $this->primeAvailable;
    }

    /**
     * Set currentPhase
     *
     * @param string $currentPhase
     * @return Project
     */
    public function setCurrentPhase($currentPhase)
    {
        $this->currentPhase = $currentPhase;

        return $this;
    }

    /**
     * Get currentPhase
     *
     * @return string 
     */
    public function getCurrentPhase()
    {
        return $this->currentPhase;
    }

    /**
     * Set folder
     *
     * @param string $folder
     * @return Project
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return string 
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Project
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }
      /**
     * Set slider
     *
     * @param string $slider
     * @return Property
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return string 
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
