<?php

namespace Crm\SandboxBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=30, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(name="mobile2", type="string", length=30, nullable=true)
     */
    private $mobile2;

    /**
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(name="unit", type="string", length=100, nullable=true)
     */
    private $unit;

    /**
     * @ORM\OneToOne(targetEntity="Lead", inversedBy="contact", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lead;

    /**
    * @ORM\ManyToOne(targetEntity="Database", inversedBy="contacts", cascade={"persist"})
    */
    private $database;

    public function __toString() {
        return $this->name ."-" .$this->id;
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
     * @return Contact
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
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Contact
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     *
     * @return Contact
     */
    public function setLead(\Crm\SandboxBundle\Entity\Lead $lead = null)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return \Crm\SandboxBundle\Entity\Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * Set database
     *
     * @param \Crm\SandboxBundle\Entity\Database $database
     *
     * @return Contact
     */
    public function setDatabase(\Crm\SandboxBundle\Entity\Database $database = null)
    {
        $this->database = $database;

        return $this;
    }

    /**
     * Get database
     *
     * @return \Crm\SandboxBundle\Entity\Database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Set mobile2
     *
     * @param string $mobile2
     * @return Contact
     */
    public function setMobile2($mobile2)
    {
        $this->mobile2 = $mobile2;

        return $this;
    }

    /**
     * Get mobile2
     *
     * @return string 
     */
    public function getMobile2()
    {
        return $this->mobile2;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Contact
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
     * Set unit
     *
     * @param string $unit
     * @return Contact
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
