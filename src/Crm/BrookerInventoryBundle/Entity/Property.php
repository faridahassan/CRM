<?php

namespace Crm\BrookerInventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Property
 *
 * @ORM\Entity(repositoryClass="Crm\BrookerInventoryBundle\DAO\PropertyRepository")
 * @ORM\Table()
 */
class Property
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
     * @ORM\Column(name="contact_name", type="string", length=255, nullable=true)
     */
    private $contactName;

    /**
     * @ORM\Column(name="contact_number", type="string", length=255, nullable=true)
     */
    private $contactNumber;

    /**
     * @ORM\Column(name="contact_email", type="string", length=255, nullable=true)
     */
    private $contactEmail;

        /**
     * @ORM\Column(name="previous_contact_name", type="string", length=255, nullable=true)
     */
    private $previousContactName;

    /**
     * @ORM\Column(name="previous_contact_number", type="string", length=255, nullable=true)
     */
    private $previousContactNumber;

    /**
     * @ORM\Column(name="previous_contact_email", type="string", length=255, nullable=true)
     */
    private $previousContactEmail;

    /**
     * @ORM\Column(name="contact_address", type="string", length=255, nullable=true)
     */
    private $contactAddress;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="properties")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="Broker", inversedBy="properties")
     * @ORM\JoinColumn(name="broker_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $broker;

    /**
     * @ORM\ManyToOne(targetEntity="Developer", inversedBy="properties")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $developer;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="properties")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phase", type="string", length=255, nullable=true)
     */
    private $phase;

    /**
     * @var string
     *
     * @ORM\Column(name="selling_type", type="string", length=255, nullable=true)
     */
    private $sellingType;

    /**
     * @var integer
     *
     * @ORM\Column(name="land_area", type="string", nullable=true)
     */
    private $landArea;

    /**
     * @var string
     *
     * @ORM\Column(name="property_type", type="string", length=255, nullable=true)
     */
    private $propertyType;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_number", type="string", length=255, nullable=true)
     */
    private $unitNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="building_number", type="string", length=255, nullable=true)
     */
    private $buildingNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="buildup_area", type="string", nullable=true)
     */
    private $buildupArea;

    /**
     * @var integer
     *
     * @ORM\Column(name="garden_area", type="string", nullable=true)
     */
    private $gardenArea;

    /**
     * @var string
     *
     * @ORM\Column(name="floors", type="string", length=255,nullable=true)
     */
    private $floors;



    /**
     * @var integer
     *
     * @ORM\Column(name="bedrooms", type="string", length=255, nullable=true)
     */
    private $bedrooms;

    /**
     * @var integer
     *
     * @ORM\Column(name="bathrooms", type="string", length=255, nullable=true)
     */
    private $bathrooms;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="instalments", type="text", nullable=true)
     */
    private $instalments;

    /**
     * @var string
     *
     * @ORM\Column(name="links", type="text", nullable=true)
     */
    private $links;

    /**
     * @var decimal
     *
     * @ORM\Column(name="asking_price", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $askingPrice;


    /**
     * @var string
     *
     * @ORM\Column(name="rent_price", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $rentPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="rent_final_price", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $rentFinalPrice;

    /**
     * @var decimal
     *
     * @ORM\Column(name="remaining", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $remaining;

    /**
     * @var decimal
     *
     * @ORM\Column(name="over", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $over;

    /**
     * @var decimal
     *
     * @ORM\Column(name="down_payment", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $downPayment;

    /**
     * @var decimal
     *
     * @ORM\Column(name="total_price", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $totalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="original_price", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $originalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="paid", type="decimal", nullable=true, precision =  12, scale = 0)
     */
    private $paid;

    /**
     * @var string
     *
     * @ORM\Column(name="buyer_commission", type="decimal", nullable=true, precision =  7, scale = 5)
     */
    private $buyerCommission;

    /**
     * @var string
     *
     * @ORM\Column(name="seller_commission", type="decimal", nullable=true, precision =  7, scale = 5)
     */
    private $sellerCommission;

    /**
     *
     * @ORM\Column(name="maintenance", type="decimal", nullable=true, precision =  12, scale = 2)
     */
    private $maintenance;

    /**
     *
     * @ORM\Column(name="transfer", type="decimal", nullable=true, precision =  12, scale = 2)
     */
    private $transfer;

    /**
     *
     * @ORM\Column(name="other_expenses", type="decimal", nullable=true, precision =  12, scale = 2)
     */
    private $otherExpenses;


    /**
     * @var string
     *
     * @ORM\Column(name="website_title", type="string", nullable=true)
     */
    private $websiteTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="website_info", type="text", nullable=true)
     */
    private $websiteInfo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delivery_date", type="datetime", nullable=true)
     */
    private $deliveryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_payment", type="datetime", nullable=true)
     */
    private $nextPayment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_payment_amount", type="integer", nullable=true)
     */
    private $nextPaymentAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="aquire_date", type="datetime", nullable=true)
     */
    private $aquireDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * @ORM\Column(name="is_sold", type="boolean")
     */
    private $isSold = false;

    /**
     * @ORM\Column(name="featured", type="boolean")
     */
    private $featured = false;

    /**
     * @ORM\Column(name="super_featured", type="boolean")
     */
    private $superFeatured = false;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\Column(name="delivered", type="boolean")
     */
    private $delivered = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $legal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $exclusivity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $eagerness;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $soldPrice;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    protected $soldDate;

    /**
     * @ORM\Column(type="boolean", length=255, nullable=true)
     */
    protected $prime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $finishing;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $furnishing ;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $view;


     /**
     * @ORM\OneToOne(
     *     targetEntity="Crm\SandboxBundle\Entity\Deal",
     *     mappedBy="property"
     * )
     */
    private $deal;

    /**
     * @ORM\Column(name="commercial", type="boolean")
     */
    private $commercial = false;

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\SandboxBundle\Entity\Call", mappedBy="properties")
     */
    private $visits;

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\SandboxBundle\Entity\Features", inversedBy="properties")
     */
    private $features;

    /**
     * @ORM\Column(type="array", length=10000, nullable=true)
     */
    protected $gallery;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $slider;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $thumbnail;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $paymentPlan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $originalImage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="property_order", type="integer", nullable=true)
     */
    private $propertyOrder = 2000000;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $folder;

    /**
     * @ORM\ManyToOne(targetEntity="\Crm\SandboxBundle\Entity\User", inversedBy="properties")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="\Crm\SandboxBundle\Entity\User", inversedBy="updatedProperties")
     */
    private $updatedBy;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="PropertyType", inversedBy="properties")
     * @ORM\JoinColumn(name="property_type_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $propertyTypeDynamic;
    




    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'images/properties/'.$this->getFolder();
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : '/'.$this->getUploadDir().'/'.$this->image;
    }

    public function __toString(){
        if ($this->project)
            return "".$this->location."-".$this->project->getName()."-".$this->id;
        return "".$this->location."-".$this->id;
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
     * @return Property
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
     * Set phase
     *
     * @param string $phase
     *
     * @return Property
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;

        return $this;
    }

    /**
     * Get phase
     *
     * @return string
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Set sellingType
     *
     * @param string $sellingType
     *
     * @return Property
     */
    public function setSellingType($sellingType)
    {
        $this->sellingType = $sellingType;

        return $this;
    }

    /**
     * Get sellingType
     *
     * @return string
     */
    public function getSellingType()
    {
        return $this->sellingType;
    }

    /**
     * Set landArea
     *
     * @param integer $landArea
     *
     * @return Property
     */
    public function setLandArea($landArea)
    {
        $this->landArea = $landArea;

        return $this;
    }

    /**
     * Get landArea
     *
     * @return integer
     */
    public function getLandArea()
    {
        return $this->landArea;
    }

    /**
     * Set propertyType
     *
     * @param string $propertyType
     *
     * @return Property
     */
    public function setPropertyType($propertyType)
    {
        $this->propertyType = $propertyType;

        return $this;
    }

    /**
     * Get propertyType
     *
     * @return string
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Property
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set unitNumber
     *
     * @param string $unitNumber
     *
     * @return Property
     */
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;

        return $this;
    }

    /**
     * Get unitNumber
     *
     * @return string
     */
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }

    /**
     * Set buildingNumber
     *
     * @param string $buildingNumber
     *
     * @return Property
     */
    public function setBuildingNumber($buildingNumber)
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }

    /**
     * Get buildingNumber
     *
     * @return string
     */
    public function getBuildingNumber()
    {
        return $this->buildingNumber;
    }

    /**
     * Set buildupArea
     *
     * @param integer $buildupArea
     *
     * @return Property
     */
    public function setBuildupArea($buildupArea)
    {
        $this->buildupArea = $buildupArea;

        return $this;
    }

    /**
     * Get buildupArea
     *
     * @return integer
     */
    public function getBuildupArea()
    {
        return $this->buildupArea;
    }

    /**
     * Set floors
     *
     * @param integer $floors
     *
     * @return Property
     */
    public function setFloors($floors)
    {
        $this->floors = $floors;

        return $this;
    }

    /**
     * Get floors
     *
     * @return integer
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     *
     * @return Property
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return integer
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Property
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Property
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set deliveryDate
     *
     * @param \DateTime $deliveryDate
     *
     * @return Property
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get deliveryDate
     *
     * @return \DateTime
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * Set commission
     *
     * @param string $commission
     *
     * @return Property
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set bathrooms
     *
     * @param integer $bathrooms
     *
     * @return Property
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    /**
     * Get bathrooms
     *
     * @return integer
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * Set deal
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Deal $deal
     *
     * @return Property
     */
    public function setDeal(\Crm\SandboxBundle\Entity\Deal $deal = null)
    {
        $this->deal = $deal;

        return $this;
    }

    /**
     * Get deal
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime('now');
        $this->visits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
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



    /**
     * Set contactName
     *
     * @param string $contactName
     * @return Property
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     * @return Property
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string 
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     * @return Property
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set contactAddress
     *
     * @param string $contactAddress
     * @return Property
     */
    public function setContactAddress($contactAddress)
    {
        $this->contactAddress = $contactAddress;

        return $this;
    }

    /**
     * Get contactAddress
     *
     * @return string 
     */
    public function getContactAddress()
    {
        return $this->contactAddress;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Property
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
     * Set gardenArea
     *
     * @param integer $gardenArea
     * @return Property
     */
    public function setGardenArea($gardenArea)
    {
        $this->gardenArea = $gardenArea;

        return $this;
    }

    /**
     * Get gardenArea
     *
     * @return integer 
     */
    public function getGardenArea()
    {
        return $this->gardenArea;
    }

    /**
     * Set floorNumber
     *
     * @param string $floorNumber
     * @return Property
     */
    public function setFloorNumber($floorNumber)
    {
        $this->floorNumber = $floorNumber;

        return $this;
    }

    /**
     * Get floorNumber
     *
     * @return string 
     */
    public function getFloorNumber()
    {
        return $this->floorNumber;
    }

    /**
     * Set askingPrice
     *
     * @param string $askingPrice
     * @return Property
     */
    public function setAskingPrice($askingPrice)
    {
        $this->askingPrice = $askingPrice;

        return $this;
    }

    /**
     * Get askingPrice
     *
     * @return string 
     */
    public function getAskingPrice()
    {
        return $this->askingPrice;
    }

    /**
     * Set remaining
     *
     * @param string $remaining
     * @return Property
     */
    public function setRemaining($remaining)
    {
        $this->remaining = $remaining;

        return $this;
    }

    /**
     * Get remaining
     *
     * @return string 
     */
    public function getRemaining()
    {
        return $this->remaining;
    }

    /**
     * Set over
     *
     * @param string $over
     * @return Property
     */
    public function setOver($over)
    {
        $this->over = $over;

        return $this;
    }

    /**
     * Get over
     *
     * @return string 
     */
    public function getOver()
    {
        return $this->over;
    }

    /**
     * Set downPayment
     *
     * @param string $downPayment
     * @return Property
     */
    public function setDownPayment($downPayment)
    {
        $this->downPayment = $downPayment;

        return $this;
    }

    /**
     * Get downPayment
     *
     * @return string 
     */
    public function getDownPayment()
    {
        return $this->downPayment;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     * @return Property
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set originalPrice
     *
     * @param string $originalPrice
     * @return Property
     */
    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = $originalPrice;

        return $this;
    }

    /**
     * Get originalPrice
     *
     * @return string 
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * Set paid
     *
     * @param string $paid
     * @return Property
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return string 
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set buyerCommission
     *
     * @param string $buyerCommission
     * @return Property
     */
    public function setBuyerCommission($buyerCommission)
    {
        $this->buyerCommission = $buyerCommission;

        return $this;
    }

    /**
     * Get buyerCommission
     *
     * @return string 
     */
    public function getBuyerCommission()
    {
        return $this->buyerCommission;
    }

    /**
     * Set sellerCommission
     *
     * @param string $sellerCommission
     * @return Property
     */
    public function setSellerCommission($sellerCommission)
    {
        $this->sellerCommission = $sellerCommission;

        return $this;
    }

    /**
     * Get sellerCommission
     *
     * @return string 
     */
    public function getSellerCommission()
    {
        return $this->sellerCommission;
    }

    /**
     * Set maintenance
     *
     * @param string $maintenance
     * @return Property
     */
    public function setMaintenance($maintenance)
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return string 
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Set transfer
     *
     * @param string $transfer
     * @return Property
     */
    public function setTransfer($transfer)
    {
        $this->transfer = $transfer;

        return $this;
    }

    /**
     * Get transfer
     *
     * @return string 
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * Set otherExpenses
     *
     * @param string $otherExpenses
     * @return Property
     */
    public function setOtherExpenses($otherExpenses)
    {
        $this->otherExpenses = $otherExpenses;

        return $this;
    }

    /**
     * Get otherExpenses
     *
     * @return string 
     */
    public function getOtherExpenses()
    {
        return $this->otherExpenses;
    }

    /**
     * Set broker
     *
     * @param string $broker
     * @return Property
     */
    public function setBroker($broker)
    {
        $this->broker = $broker;

        return $this;
    }

    /**
     * Get broker
     *
     * @return string 
     */
    public function getBroker()
    {
        return $this->broker;
    }

    /**
     * Set websiteTitle
     *
     * @param string $websiteTitle
     * @return Property
     */
    public function setWebsiteTitle($websiteTitle)
    {
        $this->websiteTitle = $websiteTitle;

        return $this;
    }

    /**
     * Get websiteTitle
     *
     * @return string 
     */
    public function getWebsiteTitle()
    {
        return $this->websiteTitle;
    }

    /**
     * Set websiteInfo
     *
     * @param string $websiteInfo
     * @return Property
     */
    public function setWebsiteInfo($websiteInfo)
    {
        $this->websiteInfo = $websiteInfo;

        return $this;
    }

    /**
     * Get websiteInfo
     *
     * @return string 
     */
    public function getWebsiteInfo()
    {
        return $this->websiteInfo;
    }

    /**
     * Set nextPayment
     *
     * @param \DateTime $nextPayment
     * @return Property
     */
    public function setNextPayment($nextPayment)
    {
        $this->nextPayment = $nextPayment;

        return $this;
    }

    /**
     * Get nextPayment
     *
     * @return \DateTime 
     */
    public function getNextPayment()
    {
        return $this->nextPayment;
    }

    /**
     * Set nextPaymentAmount
     *
     * @param integer $nextPaymentAmount
     * @return Property
     */
    public function setNextPaymentAmount($nextPaymentAmount)
    {
        $this->nextPaymentAmount = $nextPaymentAmount;

        return $this;
    }

    /**
     * Get nextPaymentAmount
     *
     * @return integer 
     */
    public function getNextPaymentAmount()
    {
        return $this->nextPaymentAmount;
    }

    /**
     * Set aquireDate
     *
     * @param \DateTime $aquireDate
     * @return Property
     */
    public function setAquireDate($aquireDate)
    {
        $this->aquireDate = $aquireDate;

        return $this;
    }

    /**
     * Get aquireDate
     *
     * @return \DateTime 
     */
    public function getAquireDate()
    {
        return $this->aquireDate;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Property
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Property
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set isSold
     *
     * @param boolean $isSold
     * @return Property
     */
    public function setIsSold($isSold)
    {
        $this->isSold = $isSold;

        return $this;
    }

    /**
     * Get isSold
     *
     * @return boolean 
     */
    public function getIsSold()
    {
        return $this->isSold;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Property
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
     * Set superFeatured
     *
     * @param boolean $superFeatured
     * @return Property
     */
    public function setSuperFeatured($superFeatured)
    {
        $this->superFeatured = $superFeatured;

        return $this;
    }

    /**
     * Get superFeatured
     *
     * @return boolean 
     */
    public function getSuperFeatured()
    {
        return $this->superFeatured;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Property
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set legal
     *
     * @param string $legal
     * @return Property
     */
    public function setLegal($legal)
    {
        $this->legal = $legal;

        return $this;
    }

    /**
     * Get legal
     *
     * @return string 
     */
    public function getLegal()
    {
        return $this->legal;
    }

    /**
     * Set exclusivity
     *
     * @param string $exclusivity
     * @return Property
     */
    public function setExclusivity($exclusivity)
    {
        $this->exclusivity = $exclusivity;

        return $this;
    }

    /**
     * Get exclusivity
     *
     * @return string 
     */
    public function getExclusivity()
    {
        return $this->exclusivity;
    }

    /**
     * Set eagerness
     *
     * @param string $eagerness
     * @return Property
     */
    public function setEagerness($eagerness)
    {
        $this->eagerness = $eagerness;

        return $this;
    }

    /**
     * Get eagerness
     *
     * @return string 
     */
    public function getEagerness()
    {
        return $this->eagerness;
    }

    /**
     * Set soldPrice
     *
     * @param string $soldPrice
     * @return Property
     */
    public function setSoldPrice($soldPrice)
    {
        $this->soldPrice = $soldPrice;

        return $this;
    }

    /**
     * Get soldPrice
     *
     * @return string 
     */
    public function getSoldPrice()
    {
        return $this->soldPrice;
    }

    /**
     * Set soldDate
     *
     * @param \DateTime $soldDate
     * @return Property
     */
    public function setSoldDate($soldDate)
    {
        $this->soldDate = $soldDate;

        return $this;
    }

    /**
     * Get soldDate
     *
     * @return \DateTime 
     */
    public function getSoldDate()
    {
        return $this->soldDate;
    }

    /**
     * Set prime
     *
     * @param boolean $prime
     * @return Property
     */
    public function setPrime($prime)
    {
        $this->prime = $prime;

        return $this;
    }

    /**
     * Get prime
     *
     * @return boolean 
     */
    public function getPrime()
    {
        return $this->prime;
    }

    /**
     * Set commercial
     *
     * @param boolean $commercial
     * @return Property
     */
    public function setCommercial($commercial)
    {
        $this->commercial = $commercial;

        return $this;
    }

    /**
     * Get commercial
     *
     * @return boolean 
     */
    public function getCommercial()
    {
        return $this->commercial;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     * @return Property
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

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Property
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set originalImage
     *
     * @param string $originalImage
     * @return Property
     */
    public function setOriginalImage($originalImage)
    {
        $this->originalImage = $originalImage;

        return $this;
    }

    /**
     * Get originalImage
     *
     * @return string 
     */
    public function getOriginalImage()
    {
        return $this->originalImage;
    }

    /**
     * Set propertyOrder
     *
     * @param integer $propertyOrder
     * @return Property
     */
    public function setPropertyOrder($propertyOrder)
    {
        $this->propertyOrder = $propertyOrder;

        return $this;
    }

    /**
     * Get propertyOrder
     *
     * @return integer 
     */
    public function getPropertyOrder()
    {
        return $this->propertyOrder;
    }

    /**
     * Set folder
     *
     * @param string $folder
     * @return Property
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
     * Set active
     *
     * @param boolean $active
     * @return Property
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set project
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Project $project
     * @return Property
     */
    public function setProject(\Crm\BrookerInventoryBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set developer
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Developer $developer
     * @return Property
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
     * Set location
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Location $location
     * @return Property
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
     * Add visits
     *
     * @param \Crm\SandboxBundle\Entity\Call $visits
     * @return Property
     */
    public function addVisit(\Crm\SandboxBundle\Entity\Call $visits)
    {
        $this->visits[] = $visits;

        return $this;
    }

    /**
     * Remove visits
     *
     * @param \Crm\SandboxBundle\Entity\Call $visits
     */
    public function removeVisit(\Crm\SandboxBundle\Entity\Call $visits)
    {
        $this->visits->removeElement($visits);
    }

    /**
     * Get visits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * Add features
     *
     * @param \Crm\SandboxBundle\Entity\Features $features
     * @return Property
     */
    public function addFeature(\Crm\SandboxBundle\Entity\Features $features)
    {
        $this->features[] = $features;

        return $this;
    }

    /**
     * Remove features
     *
     * @param \Crm\SandboxBundle\Entity\Features $features
     */
    public function removeFeature(\Crm\SandboxBundle\Entity\Features $features)
    {
        $this->features->removeElement($features);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set createdBy
     *
     * @param \Crm\SandboxBundle\Entity\User $createdBy
     * @return Property
     */
    public function setCreatedBy(\Crm\SandboxBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \Crm\SandboxBundle\Entity\User $updatedBy
     * @return Property
     */
    public function setUpdatedBy(\Crm\SandboxBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set paymentPlan
     *
     * @param string $paymentPlan
     * @return Property
     */
    public function setPaymentPlan($paymentPlan)
    {
        $this->paymentPlan = $paymentPlan;

        return $this;
    }

    /**
     * Get paymentPlan
     *
     * @return string 
     */
    public function getPaymentPlan()
    {
        return $this->paymentPlan;
    }

    /**
     * Set previousContactName
     *
     * @param string $previousContactName
     * @return Property
     */
    public function setPreviousContactName($previousContactName)
    {
        $this->previousContactName = $previousContactName;

        return $this;
    }

    /**
     * Get previousContactName
     *
     * @return string 
     */
    public function getPreviousContactName()
    {
        return $this->previousContactName;
    }

    /**
     * Set previousContactNumber
     *
     * @param string $previousContactNumber
     * @return Property
     */
    public function setPreviousContactNumber($previousContactNumber)
    {
        $this->previousContactNumber = $previousContactNumber;

        return $this;
    }

    /**
     * Get previousContactNumber
     *
     * @return string 
     */
    public function getPreviousContactNumber()
    {
        return $this->previousContactNumber;
    }

    /**
     * Set previousContactEmail
     *
     * @param string $previousContactEmail
     * @return Property
     */
    public function setPreviousContactEmail($previousContactEmail)
    {
        $this->previousContactEmail = $previousContactEmail;

        return $this;
    }

    /**
     * Get previousContactEmail
     *
     * @return string 
     */
    public function getPreviousContactEmail()
    {
        return $this->previousContactEmail;
    }

    /**
     * Set links
     *
     * @param string $links
     * @return Property
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Get links
     *
     * @return string 
     */
    public function getLinks()
    {
        return $this->links;
    }


    /**
     * Set delivered
     *
     * @param boolean $delivered
     * @return Property
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * Get delivered
     *
     * @return boolean 
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set finishing
     *
     * @param string $finishing
     * @return Property
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
     * Set furnishing
     *
     * @param string $furnishing
     * @return Property
     */
    public function setFurnishing($furnishing)
    {
        $this->furnishing = $furnishing;

        return $this;
    }

    /**
     * Get furnishing
     *
     * @return string 
     */
    public function getFurnishing()
    {
        return $this->furnishing;
    }

    /**
     * Set view
     *
     * @param string $view
     * @return Property
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return string 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set instalments
     *
     * @param string $instalments
     * @return Property
     */
    public function setInstalments($instalments)
    {
        $this->instalments = $instalments;

        return $this;
    }

    /**
     * Get instalments
     *
     * @return string 
     */
    public function getInstalments()
    {
        return $this->instalments;
    }

    /**
     * Set propertyTypeDynamic
     *
     * @param \Crm\BrookerInventoryBundle\Entity\PropertyType $propertyTypeDynamic
     * @return Property
     */
    public function setPropertyTypeDynamic(\Crm\BrookerInventoryBundle\Entity\PropertyType $propertyTypeDynamic = null)
    {
        $this->propertyTypeDynamic = $propertyTypeDynamic;

        return $this;
    }

    /**
     * Get propertyTypeDynamic
     *
     * @return \Crm\BrookerInventoryBundle\Entity\PropertyType 
     */
    public function getPropertyTypeDynamic()
    {
        return $this->propertyTypeDynamic;
    }

    /**
     * Set rentPrice
     *
     * @param string $rentPrice
     * @return Property
     */
    public function setRentPrice($rentPrice)
    {
        $this->rentPrice = $rentPrice;

        return $this;
    }

    /**
     * Get rentPrice
     *
     * @return string 
     */
    public function getRentPrice()
    {
        return $this->rentPrice;
    }

    /**
     * Set rentFinalPrice
     *
     * @param string $rentFinalPrice
     * @return Property
     */
    public function setRentFinalPrice($rentFinalPrice)
    {
        $this->rentFinalPrice = $rentFinalPrice;

        return $this;
    }

    /**
     * Get rentFinalPrice
     *
     * @return string 
     */
    public function getRentFinalPrice()
    {
        return $this->rentFinalPrice;
    }
}
