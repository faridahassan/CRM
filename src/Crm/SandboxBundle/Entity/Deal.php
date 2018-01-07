<?php

namespace Crm\SandboxBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\DealRepository")
 */
class Deal
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
     * @var boolean
     *
     * @ORM\Column(name="closed", type="boolean", nullable=true)
     */
    private $closed;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="deposit", type="integer", nullable=true)
     */
    private $deposit;

    /**
     * @var string
     *
     * @ORM\Column(name="commission", type="decimal", nullable=true, precision =  7, scale = 2)
     */
    private $commission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    private $approved;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="deals")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Lead", inversedBy="deals")
     * @Assert\NotBlank()
     */
    private $lead;

    /**
     * @var date
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var date
     * @ORM\Column(name="closed_date", type="datetime", nullable=true)
     */
    private $closedDate;

    /**
     * @ORM\OneToOne(
     *     targetEntity="\Crm\BrookerInventoryBundle\Entity\Property",
     *     inversedBy="deal"
     * )
     * @ORM\JoinColumn(name="property", referencedColumnName="id", unique=true)
     * @Assert\NotBlank()
     */
    private $property;

    /**
     * @ORM\ManyToOne(targetEntity="\Crm\BrookerInventoryBundle\Entity\Team", inversedBy="deals")
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
     * Set closed
     *
     * @param boolean $closed
     * @return Deal
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean 
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Deal
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set deposit
     *
     * @param integer $deposit
     * @return Deal
     */
    public function setDeposit($deposit)
    {
        $this->deposit = $deposit;

        return $this;
    }

    /**
     * Get deposit
     *
     * @return integer 
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * Set commission
     *
     * @param integer $commission
     * @return Deal
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return integer 
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     * @return Deal
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Deal
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
     * Set user
     *
     * @param \Crm\SandboxBundle\Entity\User $user
     * @return Deal
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
     * Set lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     * @return Deal
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
     * Set property
     *
     * @param \Crm\SandboxBundle\Entity\Property $property
     * @return Deal
     */
    public function setProperty(\Crm\BrookerInventoryBundle\Entity\Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return \Crm\SandboxBundle\Entity\Property 
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set closedDate
     *
     * @param \DateTime $closedDate
     * @return Deal
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
     * Set team
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Team $team
     * @return Deal
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
