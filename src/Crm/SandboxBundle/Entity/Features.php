<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Features
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Features
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(name="type", type="integer")
     */
    private $type = 0;
    // Type 0:Default feature, 1:Location

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\BrookerInventoryBundle\Entity\Property", mappedBy="features")
     */
    private $properties;

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\SandboxBundle\Entity\Lead", mappedBy="features")
     */
    private $leads;

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
     * Set featureItem
     *
     * @param \Crm\SandboxBundle\Entity\FeatureItem $featureItem
     * @return Features
     */
    public function setFeatureItem(\Crm\SandboxBundle\Entity\FeatureItem $featureItem = null)
    {
        $this->featureItem = $featureItem;

        return $this;
    }

    /**
     * Get featureItem
     *
     * @return \Crm\SandboxBundle\Entity\FeatureItem 
     */
    public function getFeatureItem()
    {
        return $this->featureItem;
    }

    /**
     * Set value
     *
     * @param boolean $value
     * @return Features
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return boolean 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Features
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
     * Add properties
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $properties
     * @return Features
     */
    public function addProperty(\Crm\BrookerInventoryBundle\Entity\Property $properties)
    {
        $this->properties[] = $properties;

        return $this;
    }

    /**
     * Remove properties
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $properties
     */
    public function removeProperty(\Crm\BrookerInventoryBundle\Entity\Property $properties)
    {
        $this->properties->removeElement($properties);
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
     * Set type
     *
     * @param integer $type
     * @return Features
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add leads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $leads
     * @return Features
     */
    public function addLead(\Crm\SandboxBundle\Entity\Lead $leads)
    {
        $this->leads[] = $leads;

        return $this;
    }

    /**
     * Remove leads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $leads
     */
    public function removeLead(\Crm\SandboxBundle\Entity\Lead $leads)
    {
        $this->leads->removeElement($leads);
    }

    /**
     * Get leads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLeads()
    {
        return $this->leads;
    }
}
