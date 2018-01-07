<?php
namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\ComplaintRepository")
 * @ORM\Table(name="Complaint")
 */
class Complaint
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    

    /**
    * @ORM\ManyToOne(targetEntity="Lead", inversedBy="complaints",cascade={"persist"})
    */
    private $lead;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
    */
    private $name;

    /**
     * @ORM\Column(name="mobile", type="string", length=255, nullable=true)
    */
    private $mobile;

    /**
     * @ORM\Column(name="brief", type="string", length=255, nullable=true)
    */
    private $brief;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
    */
    private $description;

    /**
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
    */
    private $status;

    /**
     * @ORM\Column(name="department", type="string", length=255, nullable=true)
    */
    private $department;
    
    /**
    *
    * @ORM\ManyToOne(targetEntity="User", inversedBy="complaintsCreated")
    */
    private $userCreating;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="complaintsClosed")
    */
    private $userClosing;

    /**
     * @var string
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

        /**
     * @var string
     * @ORM\Column(name="closeddate", type="datetime",nullable=true)
     */
    private $closedDate;

    /**
     * @ORM\OneToMany(targetEntity="ComplaintLog", mappedBy="complaint")
     */
    private $log;
    


    /**
     * Constructor
     */
    public function __construct()
    {
        
    }
    public function __toString() {
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
     * @return Complaint
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
     * Set brief
     *
     * @param string $brief
     * @return Complaint
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return string 
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Complaint
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
     * Set status
     *
     * @param string $status
     * @return Complaint
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return Complaint
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     * @return Complaint
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
     * Set userCreating
     *
     * @param \Crm\SandboxBundle\Entity\User $userCreating
     * @return Complaint
     */
    public function setUserCreating(\Crm\SandboxBundle\Entity\User $userCreating = null)
    {
        $this->userCreating = $userCreating;

        return $this;
    }

    /**
     * Get userCreating
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getUserCreating()
    {
        return $this->userCreating;
    }

    /**
     * Set userClosing
     *
     * @param \Crm\SandboxBundle\Entity\User $userClosing
     * @return Complaint
     */
    public function setUserClosing(\Crm\SandboxBundle\Entity\User $userClosing = null)
    {
        $this->userClosing = $userClosing;

        return $this;
    }

    /**
     * Get userClosing
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getUserClosing()
    {
        return $this->userClosing;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Complaint
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set closedDate
     *
     * @param \DateTime $closedDate
     * @return Complaint
     */
    public function setClosedDate($closedDate)
    {
        $this->closedDate = $closedDate;

        return $this;
    }

    /**
     * Get closedDate
     *
     * @return \DateTime 
     */
    public function getClosedDate()
    {
        return $this->closedDate;
    }

    /**
     * Add log
     *
     * @param \Crm\SandboxBundle\Entity\ComplaintLog $log
     * @return Complaint
     */
    public function addLog(\Crm\SandboxBundle\Entity\ComplaintLog $log)
    {
        $this->log[] = $log;

        return $this;
    }

    /**
     * Remove log
     *
     * @param \Crm\SandboxBundle\Entity\ComplaintLog $log
     */
    public function removeLog(\Crm\SandboxBundle\Entity\ComplaintLog $log)
    {
        $this->log->removeElement($log);
    }

    /**
     * Get log
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return Complaint
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
}
