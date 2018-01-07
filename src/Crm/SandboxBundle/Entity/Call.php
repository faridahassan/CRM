<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Call
 *
 * @ORM\Table(name="call_table")
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\CallRepository")
 */
class Call
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="outcome", type="text", nullable=true)
     */
    private $outcome;

    /**
     * @var string
     * @ORM\Column(name="interested_in", type="text", nullable=true)
     */
    private $interestedIn;

    /**
     * @var string
     * @ORM\Column(name="objective", type="string", length=255, nullable=true)
     */
    private $objective;

    /**
     * @var string
     * @ORM\Column(name="orientation", type="string", length=255, nullable=true)
     */
    private $orientation;

    /**
     * @var string
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Lead", inversedBy="calls")
     */
    private $lead;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="callLogs")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="Task", mappedBy="call", cascade={"persist"})
     */
    private $task;

    /**
     * @var boolean
     * @ORM\Column(name="is_call", type="boolean", nullable=true)
     */
    private $isCall;



    /**
     * @ORM\ManyToMany(targetEntity="\Crm\BrookerInventoryBundle\Entity\Property", inversedBy="visits")
     */
    private $properties;

    /**
     * @ORM\ManyToOne(targetEntity="\Crm\BrookerInventoryBundle\Entity\Team", inversedBy="calls")
     * @ORM\JoinColumn(name="team_id", onDelete="SET NULL")
     */
    private $team;


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
     * Set outcome
     *
     * @param string $outcome
     *
     * @return Call
     */
    public function setOutcome($outcome)
    {
        $this->outcome = $outcome;

        return $this;
    }

    /**
     * Get outcome
     *
     * @return string
     */
    public function getOutcome()
    {
        return $this->outcome;
    }

    /**
     * Set objective
     *
     * @param string $objective
     *
     * @return Call
     */
    public function setObjective($objective)
    {
        $this->objective = $objective;

        return $this;
    }

    /**
     * Get objective
     *
     * @return string
     */
    public function getObjective()
    {
        return $this->objective;
    }

    /**
     * Set orientation
     *
     * @param string $orientation
     *
     * @return Call
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Call
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
     * Set isCall
     *
     * @param boolean $isCall
     *
     * @return Call
     */
    public function setIsCall($isCall)
    {
        $this->isCall = $isCall;

        return $this;
    }

    /**
     * Get isCall
     *
     * @return boolean
     */
    public function getIsCall()
    {
        return $this->isCall;
    }

    /**
     * Set lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     *
     * @return Call
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
     * Set user
     *
     * @param \Crm\SandboxBundle\Entity\User $user
     *
     * @return Call
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
     * Set interestedIn
     *
     * @param string $interestedIn
     *
     * @return Call
     */
    public function setInterestedIn($interestedIn)
    {
        $this->interestedIn = $interestedIn;

        return $this;
    }

    /**
     * Get interestedIn
     *
     * @return string
     */
    public function getInterestedIn()
    {
        return $this->interestedIn;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add properties
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $properties
     * @return Call
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
     * Add tasks
     *
     * @param \Crm\SandboxBundle\Entity\Task $tasks
     * @return Call
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
     * Set task
     *
     * @param \Crm\SandboxBundle\Entity\Task $task
     * @return Call
     */
    public function setTask(\Crm\SandboxBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \Crm\SandboxBundle\Entity\Task 
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set team
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Team $team
     * @return Call
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
