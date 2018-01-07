<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Lead
 *
 * @ORM\Table(name="lead_table")
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\LeadRepository")
 */
class Lead
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
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluation", type="string", length=255, nullable=true)
     */
    private $evaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="opportunity", type="boolean")
     */
    private $opportunity = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="new", type="boolean")
     */
    private $new = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="budget", type="integer", nullable=true)
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity="Call", mappedBy="lead")
     */
    private $calls;

    /**
     * @ORM\OneToMany(targetEntity="Deal", mappedBy="lead")
     */
    private $deals;

    /**
     * @ORM\Column(name="is_lead", type="boolean")
     */
    private $isLead = true;

        /**
     * @ORM\Column(name="is_lead_reason", type="string" ,length=255,nullable = true)
     */
    private $isLeadReason;

    /**
     * @ORM\Column(name="is_interested", type="boolean")
     */
    private $isInterested = true;

    /**
     * @ORM\Column(name="is_interested_reason", type="string", length=255, nullable = true)
     */
    private $isInterestedReason;

    /**
     * status is 0 for client, 1 for trashed
     * @ORM\Column(name="closed_status", type="boolean", nullable = true)
     */
    private $closedStatus;

    /**
     * @ORM\OneToOne(targetEntity="Contact", mappedBy="lead",cascade={"persist"})
     */
    private $contact;

    /**
    * //This is the user that created the lead
    * @ORM\ManyToOne(targetEntity="User", inversedBy="leads")
    */
    private $user;

    /**
    * //This is the sales rep that is assigned to the lead
    * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedLeads")
    */
    private $assignedSalesRep;

        /**
    * //This is the sales rep that is assigned to the lead
    * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedLeads", cascade={"persist"})
    */
    private $owner;

    /**
     * @ORM\Column(name="sales_rep_assign_date", type="datetime", nullable=true)
     */
    private $salesRepAssignDate;

    /**
    * @ORM\ManyToOne(targetEntity="SubChannel", inversedBy="leads", cascade={"persist"})
    */
    private $subChannel;

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\SandboxBundle\Entity\Features", inversedBy="leads")
     */
    private $features;

    /**
     * @ORM\ManyToMany(targetEntity="\Crm\BrookerInventoryBundle\Entity\Location", inversedBy="leads")
     */
    private $locations;

    /**
     * @ORM\Column(type="array", length=10000, nullable=true)
     */
    private $typeFeatures;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="Complaint", mappedBy="lead")
     */
    private $complaints;
    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="lead")
     */
    private $tasks;

    /**
     * @ORM\ManyToOne(targetEntity="\Crm\BrookerInventoryBundle\Entity\Team", inversedBy="leads")
     * @ORM\JoinColumn(name="team_id", onDelete="SET NULL")
     */
    private $team;

    /**
     * @var boolean
     *
     * @ORM\Column(name="complaint", type="boolean")
     */
    private $complaint = false;

    public function __construct() {
        $this->calls = new ArrayCollection();
        $this->deals = new ArrayCollection();
        $this->date = new \DateTime();
        $this->tasks = new ArrayCollection();
    }


    public function is_empty($var)
    { 
     return empty($var);
    }

    public function __toString() {
        if($this->is_empty($this->getContact()))
            return "Name not set!";
        if(strlen($this->getContact()->getName()) == 0)
            return "Name not set!";
        return $this->getContact()->getName();
    }
    public function getMeetingsOnly()
    {
        $meetings = [];
        foreach ($this->calls as $call ){
            if (!$call->getIsCall()) {
                $meetings[] = $call;
            }
        }
        return $meetings;
    }
    public function getCallsOnly()
    {
        $calls = [];
        foreach ($this->calls as $call ){
            if ($call->getIsCall()) {
                $calls[] = $call;
            }
        }
        return $calls;
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
     * Set info
     *
     * @param string $info
     *
     * @return Lead
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Lead
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
     * Set evaluation
     *
     * @param string $evaluation
     *
     * @return Lead
     */
    public function setEvaluation($evaluation)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return string
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Lead
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
     * Set opportunity
     *
     * @param string $opportunity
     *
     * @return Lead
     */
    public function setOpportunity($opportunity)
    {
        $this->opportunity = $opportunity;

        return $this;
    }

    /**
     * Get opportunity
     *
     * @return string
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }

    /**
     * Set budget
     *
     * @param integer $budget
     *
     * @return Lead
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return integer
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set isLead
     *
     * @param boolean $isLead
     *
     * @return Lead
     */
    public function setIsLead($isLead)
    {
        $this->isLead = $isLead;

        return $this;
    }

    /**
     * Get isLead
     *
     * @return boolean
     */
    public function getIsLead()
    {
        return $this->isLead;
    }

    /**
     * Add call
     *
     * @param \Crm\SandboxBundle\Entity\Call $call
     *
     * @return Lead
     */
    public function addCall(\Crm\SandboxBundle\Entity\Call $call)
    {
        $this->calls[] = $call;

        return $this;
    }

    /**
     * Remove call
     *
     * @param \Crm\SandboxBundle\Entity\Call $call
     */
    public function removeCall(\Crm\SandboxBundle\Entity\Call $call)
    {
        $this->calls->removeElement($call);
    }

    /**
     * Get calls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * Add deal
     *
     * @param \Crm\SandboxBundle\Entity\Deal $deal
     *
     * @return Lead
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
     * Set contact
     *
     * @param \Crm\SandboxBundle\Entity\Contact $contact
     *
     * @return Lead
     */
    public function setContact(\Crm\SandboxBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \Crm\SandboxBundle\Entity\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set user
     *
     * @param \Crm\SandboxBundle\Entity\User $user
     *
     * @return Lead
     */
    public function setUser(\Crm\SandboxBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Crm\SandboxBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set assignedSalesRep
     *
     * @param \Crm\SandboxBundle\Entity\User $assignedSalesRep
     *
     * @return Lead
     */
    public function setAssignedSalesRep(\Crm\SandboxBundle\Entity\User $assignedSalesRep = null)
    {
        $this->assignedSalesRep = $assignedSalesRep;

        return $this;
    }

    /**
     * Get assignedSalesRep
     *
     * @return \Crm\SandboxBundle\Entity\User
     */
    public function getAssignedSalesRep()
    {
        return $this->assignedSalesRep;
    }

    /**
     * Set subChannel
     *
     * @param \Crm\SandboxBundle\Entity\SubChannel $subChannel
     *
     * @return Lead
     */
    public function setSubChannel(\Crm\SandboxBundle\Entity\SubChannel $subChannel = null)
    {
        $this->subChannel = $subChannel;

        return $this;
    }

    /**
     * Get subChannel
     *
     * @return \Crm\SandboxBundle\Entity\SubChannel
     */
    public function getSubChannel()
    {
        return $this->subChannel;
    }

    /**
     * Add features
     *
     * @param \Crm\SandboxBundle\Entity\Features $features
     * @return Lead
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
     * Set new
     *
     * @param boolean $new
     * @return Lead
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return boolean 
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Set isLeadReason
     *
     * @param string $isLeadReason
     * @return Lead
     */
    public function setIsLeadReason($isLeadReason)
    {
        $this->isLeadReason = $isLeadReason;

        return $this;
    }

    /**
     * Get isLeadReason
     *
     * @return string 
     */
    public function getIsLeadReason()
    {
        return $this->isLeadReason;
    }

    /**
     * Set isInterested
     *
     * @param boolean $isInterested
     * @return Lead
     */
    public function setIsInterested($isInterested)
    {
        $this->isInterested = $isInterested;

        return $this;
    }

    /**
     * Get isInterested
     *
     * @return boolean 
     */
    public function getIsInterested()
    {
        return $this->isInterested;
    }

    /**
     * Set isInterestedReason
     *
     * @param string $isInterestedReason
     * @return Lead
     */
    public function setIsInterestedReason($isInterestedReason)
    {
        $this->isInterestedReason = $isInterestedReason;

        return $this;
    }

    /**
     * Get isInterestedReason
     *
     * @return string 
     */
    public function getIsInterestedReason()
    {
        return $this->isInterestedReason;
    }

    /**
     * Set closedStatus
     *
     * @param boolean $closedStatus
     * @return Lead
     */
    public function setClosedStatus($closedStatus)
    {
        $this->closedStatus = $closedStatus;

        return $this;
    }

    /**
     * Get closedStatus
     *
     * @return boolean 
     */
    public function getClosedStatus()
    {
        return $this->closedStatus;
    }

    /**
     * Set salesRepAssignDate
     *
     * @param \DateTime $salesRepAssignDate
     * @return Lead
     */
    public function setSalesRepAssignDate($salesRepAssignDate)
    {
        $this->salesRepAssignDate = $salesRepAssignDate;

        return $this;
    }

    /**
     * Get salesRepAssignDate
     *
     * @return \DateTime 
     */
    public function getSalesRepAssignDate()
    {
        return $this->salesRepAssignDate;
    }

    /**
     * Set typeFeatures
     *
     * @param array $typeFeatures
     * @return Lead
     */
    public function setTypeFeatures($typeFeatures)
    {
        $this->typeFeatures = $typeFeatures;

        return $this;
    }

    /**
     * Get typeFeatures
     *
     * @return array 
     */
    public function getTypeFeatures()
    {
        return $this->typeFeatures;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Lead
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
     * Set complaint
     *
     * @param boolean $complaint
     * @return Lead
     */
    public function setComplaint($complaint)
    {
        $this->complaint = $complaint;

        return $this;
    }

    /**
     * Get complaint
     *
     * @return boolean 
     */
    public function getComplaint()
    {
        return $this->complaint;
    }

    /**
     * Set owner
     *
     * @param \Crm\SandboxBundle\Entity\User $owner
     * @return Lead
     */
    public function setOwner(\Crm\SandboxBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add locations
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Location $locations
     * @return Lead
     */
    public function addLocation(\Crm\BrookerInventoryBundle\Entity\Location $locations)
    {
        $this->locations[] = $locations;

        return $this;
    }

    /**
     * Remove locations
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Location $locations
     */
    public function removeLocation(\Crm\BrookerInventoryBundle\Entity\Location $locations)
    {
        $this->locations->removeElement($locations);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Add complaints
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaints
     * @return Lead
     */
    public function addComplaint(\Crm\SandboxBundle\Entity\Complaint $complaints)
    {
        $this->complaints[] = $complaints;

        return $this;
    }

    /**
     * Remove complaints
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaints
     */
    public function removeComplaint(\Crm\SandboxBundle\Entity\Complaint $complaints)
    {
        $this->complaints->removeElement($complaints);
    }

    /**
     * Get complaints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComplaints()
    {
        return $this->complaints;
    }

    /**
     * Add tasks
     *
     * @param \Crm\SandboxBundle\Entity\Task $tasks
     * @return Lead
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
     * Set team
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Team $team
     * @return Lead
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
}
