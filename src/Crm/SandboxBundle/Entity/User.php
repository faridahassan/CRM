<?php

namespace Crm\SandboxBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Crm\BrookerInventoryBundle\Entity\Property;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     * @ORM\Column(name="name", type="string",nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(name="target", type="integer", nullable=true)
     */
    private $target;

    /**
     * @ORM\OneToMany(targetEntity="Lead", mappedBy="user")
     */
    private $leads;

    /**
     * @ORM\OneToMany(targetEntity="Lead", mappedBy="assignedSalesRep")
     */
    private $assignedLeads;
    /**
     * @ORM\OneToMany(targetEntity="Complaint", mappedBy="userCreating")
     */
    private $complaintsCreated;
        /**
     * @ORM\OneToMany(targetEntity="Complaint", mappedBy="userClosing")
     */
    private $complaintsClosed;
    /**
     * @ORM\OneToMany(targetEntity="Database", mappedBy="user")
     */
    private $databases;
    /**
     * @ORM\OneToMany(targetEntity="ComplaintLog", mappedBy="user")
     */
    private $complaintLog;

    /**
     * @ORM\OneToMany(targetEntity="Lead", mappedBy="owner")
     */
    private $ownedLeads;


    /**
     * @ORM\OneToMany(targetEntity="Call", mappedBy="user")
     */
    private $callLogs;

    /**
     * @ORM\OneToMany(targetEntity="Deal", mappedBy="user")
     */
    private $deals;

    /**
     * @ORM\OneToOne(targetEntity="\Crm\BrookerInventoryBundle\Entity\Team", mappedBy="leader")
     */
    private $ledTeam;

    /**
     * @ORM\ManyToOne(targetEntity="\Crm\BrookerInventoryBundle\Entity\Team", inversedBy="users")
     * @ORM\JoinColumn(name="team_id", onDelete="SET NULL")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="\Crm\BrookerInventoryBundle\Entity\Property", mappedBy="createdBy")
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity="\Crm\BrookerInventoryBundle\Entity\Property", mappedBy="updatedBy")
     */
    private $updatedProperties;

    /**
     * @var string
     * @ORM\Column(name="takelead", type="boolean")
     */
    private $takeLead = false;

    /**
     * @ORM\Column(name="autoassign", type="boolean")
     */
    private $autoassign = false;

    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;
    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;

    /** @ORM\Column(name="google_refresh_token", type="string", length=255, nullable=true) */
    protected $google_refresh_token;


    public function __construct()
    {
        parent::__construct();
        $this->leads         = new ArrayCollection();
        $this->assignedLeads = new ArrayCollection();
        $this->callLogs      = new ArrayCollection();
        $this->deals         = new ArrayCollection();
        $this->tasks         = new ArrayCollection();
        $this->properties    = new ArrayCollection();
    }
    public function getRole()
    {
        return $this->roles[0];
    }
    /*****
     * Calculates completed target
     */                            
    public function getProgressedTarget()
    {
        $progressedTarget = 0;

        foreach($this->deals as $deal)        
        {
            if ($deal->getClosed() && $deal->getApproved())
            {
               $progressedTarget+= $deal->getPrice(); 
            }
        }
        return $progressedTarget;
    }

    public function getProgressedTargetPercentage()
    {
        if($this->target)
            return (($this->getProgressedTarget() / $this->target) * 100);
        else
            return 0;
    }

    /**
     * Add lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     *
     * @return User
     */
    public function addLead(\Crm\SandboxBundle\Entity\Lead $lead)
    {
        $this->leads[] = $lead;

        return $this;
    }

    /**
     * Remove lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     */
    public function removeLead(\Crm\SandboxBundle\Entity\Lead $lead)
    {
        $this->leads->removeElement($lead);
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

    /**
     * Add callLog
     *
     * @param \Crm\SandboxBundle\Entity\Call $callLog
     *
     * @return User
     */
    public function addCallLog(\Crm\SandboxBundle\Entity\Call $callLog)
    {
        $this->callLogs[] = $callLog;

        return $this;
    }

    /**
     * Remove callLog
     *
     * @param \Crm\SandboxBundle\Entity\Call $callLog
     */
    public function removeCallLog(\Crm\SandboxBundle\Entity\Call $callLog)
    {
        $this->callLogs->removeElement($callLog);
    }

    /**
     * Get callLogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCallLogs()
    {
        return $this->callLogs;
    }

    /**
     * Add assignedLead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $assignedLead
     *
     * @return User
     */
    public function addAssignedLead(\Crm\SandboxBundle\Entity\Lead $assignedLead)
    {
        $this->assignedLeads[] = $assignedLead;

        return $this;
    }

    /**
     * Remove assignedLead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $assignedLead
     */
    public function removeAssignedLead(\Crm\SandboxBundle\Entity\Lead $assignedLead)
    {
        $this->assignedLeads->removeElement($assignedLead);
    }

    /**
     * Get assignedLeads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignedLeads()
    {
        return $this->assignedLeads;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Add deal
     *
     * @param \Crm\SandboxBundle\Entity\Deal $deal
     *
     * @return User
     */
    public function addDeal(\Crm\SandboxBundle\Entity\Deal $deal)
    {
        $this->deals[] = $deal;

        return $this;
    }

    /**
     * Remove deal
     *
     * @param \Crm\SandboxBundle\Entity\Deal $deal
     */
    public function removeDeal(\Crm\SandboxBundle\Entity\Deal $deal)
    {
        $this->deals->removeElement($deal);
    }

    /**
     * Get deals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeals()
    {
        return $this->deals;
    }

    /**
     * Set target
     *
     * @param integer $target
     * @return User
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return integer 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set team
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Team $team
     * @return User
     */
    public function setTeam(\Crm\BrookerInventoryBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set ledTeam
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Team $ledTeam
     * @return User
     */
    public function setLedTeam(\Crm\BrookerInventoryBundle\Entity\Team $ledTeam = null)
    {
        $this->ledTeam = $ledTeam;

        return $this;
    }

    /**
     * Get ledTeam
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Team 
     */
    public function getLedTeam()
    {
        return $this->ledTeam;
    }

    /**
     * Add tasks
     *
     * @param \Crm\SandboxBundle\Entity\Task $tasks
     * @return User
     */
    public function addTask(\Crm\SandboxBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Crm\SandboxBundle\Entity\Task $tasks
     */
    public function removeTask(\Crm\SandboxBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add properties
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $properties
     * @return User
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
     * Set takeLead
     *
     * @param boolean $takeLead
     * @return User
     */
    public function setTakeLead($takeLead)
    {
        $this->takeLead = $takeLead;

        return $this;
    }

    /**
     * Get takeLead
     *
     * @return boolean 
     */
    public function getTakeLead()
    {
        return $this->takeLead;
    }

    /**
     * Set google_id
     *
     * @param string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get google_id
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set google_access_token
     *
     * @param string $googleAccessToken
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get google_access_token
     *
     * @return string 
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set google_refresh_token
     *
     * @param string $googleRefreshToken
     * @return User
     */
    public function setGoogleRefreshToken($googleRefreshToken)
    {
        $this->google_refresh_token = $googleRefreshToken;

        return $this;
    }

    /**
     * Get google_refresh_token
     *
     * @return string 
     */
    public function getGoogleRefreshToken()
    {
        return $this->google_refresh_token;
    }

    /**
     * Add updatedProperties
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $updatedProperties
     * @return User
     */
    public function addUpdatedProperty(\Crm\BrookerInventoryBundle\Entity\Property $updatedProperties)
    {
        $this->updatedProperties[] = $updatedProperties;

        return $this;
    }

    /**
     * Remove updatedProperties
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $updatedProperties
     */
    public function removeUpdatedProperty(\Crm\BrookerInventoryBundle\Entity\Property $updatedProperties)
    {
        $this->updatedProperties->removeElement($updatedProperties);
    }

    /**
     * Get updatedProperties
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUpdatedProperties()
    {
        return $this->updatedProperties;
    }

    /**
     * Add ownedLeads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $ownedLeads
     * @return User
     */
    public function addOwnedLead(\Crm\SandboxBundle\Entity\Lead $ownedLeads)
    {
        $this->ownedLeads[] = $ownedLeads;

        return $this;
    }

    /**
     * Remove ownedLeads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $ownedLeads
     */
    public function removeOwnedLead(\Crm\SandboxBundle\Entity\Lead $ownedLeads)
    {
        $this->ownedLeads->removeElement($ownedLeads);
    }

    /**
     * Get ownedLeads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnedLeads()
    {
        return $this->ownedLeads;
    }

    /**
     * Set autoassign
     *
     * @param boolean $autoassign
     * @return User
     */
    public function setAutoassign($autoassign)
    {
        $this->autoassign = $autoassign;

        return $this;
    }

    /**
     * Get autoassign
     *
     * @return boolean 
     */
    public function getAutoassign()
    {
        return $this->autoassign;
    }

    /**
     * Add complaintsCreated
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaintsCreated
     * @return User
     */
    public function addComplaintsCreated(\Crm\SandboxBundle\Entity\Complaint $complaintsCreated)
    {
        $this->complaintsCreated[] = $complaintsCreated;

        return $this;
    }

    /**
     * Remove complaintsCreated
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaintsCreated
     */
    public function removeComplaintsCreated(\Crm\SandboxBundle\Entity\Complaint $complaintsCreated)
    {
        $this->complaintsCreated->removeElement($complaintsCreated);
    }

    /**
     * Get complaintsCreated
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComplaintsCreated()
    {
        return $this->complaintsCreated;
    }

    /**
     * Add complaintsClosed
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaintsClosed
     * @return User
     */
    public function addComplaintsClosed(\Crm\SandboxBundle\Entity\Complaint $complaintsClosed)
    {
        $this->complaintsClosed[] = $complaintsClosed;

        return $this;
    }

    /**
     * Remove complaintsClosed
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaintsClosed
     */
    public function removeComplaintsClosed(\Crm\SandboxBundle\Entity\Complaint $complaintsClosed)
    {
        $this->complaintsClosed->removeElement($complaintsClosed);
    }

    /**
     * Get complaintsClosed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComplaintsClosed()
    {
        return $this->complaintsClosed;
    }

    /**
     * Add complaintLog
     *
     * @param \Crm\SandboxBundle\Entity\ComplaintLog $complaintLog
     * @return User
     */
    public function addComplaintLog(\Crm\SandboxBundle\Entity\ComplaintLog $complaintLog)
    {
        $this->complaintLog[] = $complaintLog;

        return $this;
    }

    /**
     * Remove complaintLog
     *
     * @param \Crm\SandboxBundle\Entity\ComplaintLog $complaintLog
     */
    public function removeComplaintLog(\Crm\SandboxBundle\Entity\ComplaintLog $complaintLog)
    {
        $this->complaintLog->removeElement($complaintLog);
    }

    /**
     * Get complaintLog
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComplaintLog()
    {
        return $this->complaintLog;
    }

    /**
     * Add databases
     *
     * @param \Crm\SandboxBundle\Entity\Database $databases
     * @return User
     */
    public function addDatabase(\Crm\SandboxBundle\Entity\Database $databases)
    {
        $this->databases[] = $databases;

        return $this;
    }

    /**
     * Remove databases
     *
     * @param \Crm\SandboxBundle\Entity\Database $databases
     */
    public function removeDatabase(\Crm\SandboxBundle\Entity\Database $databases)
    {
        $this->databases->removeElement($databases);
    }

    /**
     * Get databases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatabases()
    {
        return $this->databases;
    }
}
