<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeatureItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FeatureItem
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
     * @ORM\OneToMany(targetEntity="Features", mappedBy="featureItem")
     */
    private $features;


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
     * @return FeatureItem
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
     * Constructor
     */
    public function __construct()
    {
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add features
     *
     * @param \Crm\SandboxBundle\Entity\Features $features
     * @return FeatureItem
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
}
