<?php

namespace Crm\BrookerInventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Location
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Property", mappedBy="location")
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="location")
     */
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\SandboxBundle\Entity\Lead", mappedBy="locationFeatures")
     */
    private $leads;

    // *
    //  * @ORM\ManyToMany(targetEntity="Developer", mappedBy="locations")
     
    // private $developers;

    public function __toString() 
    {
        return $this->name;
    }


    public function __construct()
    {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->developers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Location
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
     * @return Location
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
     * Add projects
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Project $projects
     * @return Location
     */
    public function addProject(\Crm\BrookerInventoryBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Project $projects
     */
    public function removeProject(\Crm\BrookerInventoryBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add developers
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Developer $developers
     * @return Location
     */
    public function addDeveloper(\Crm\BrookerInventoryBundle\Entity\Developer $developers)
    {
        $this->developers[] = $developers;

        return $this;
    }

    /**
     * Remove developers
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Developer $developers
     */
    public function removeDeveloper(\Crm\BrookerInventoryBundle\Entity\Developer $developers)
    {
        $this->developers->removeElement($developers);
    }

    /**
     * Get developers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDevelopers()
    {
        return $this->developers;
    }

    /**
     * Add leads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $leads
     * @return Location
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
