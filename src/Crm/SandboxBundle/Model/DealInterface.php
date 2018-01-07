<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


interface class AbstractDeal
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
     * @ORM\Column(name="unit", type="string", length=255)
     */
    private $unit;

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
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="deposit", type="integer")
     */
    private $deposit;

    /**
     * @var integer
     *
     * @ORM\Column(name="instalmentValue", type="integer")
     */
    private $instalmentValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="instalments", type="integer")
     */
    private $instalments;

    /**
     * @var integer
     *
     * @ORM\Column(name="paidInstalment", type="integer")
     */
    private $paidInstalment;

    /**
     * @var integer
     *
     * @ORM\Column(name="commission", type="integer")
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
     */
    private $lead;

    /**
     * @var date
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set unit
     *
     * @param string $unit
     *
     * @return Deal
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

    /**
     * Set price
     *
     * @param integer $price
     *
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
     * Set commission
     *
     * @param integer $commission
     *
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
     * Set user
     *
     * @param \Crm\SandboxBundle\Entity\User $user
     *
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
     * Set approved
     *
     * @param boolean $approved
     *
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
     * Set deposit
     *
     * @param integer $deposit
     *
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
     * Set instalment
     *
     * @param integer $instalment
     *
     * @return Deal
     */
    public function setInstalment($instalment)
    {
        $this->instalment = $instalment;

        return $this;
    }

    /**
     * Get instalment
     *
     * @return integer
     */
    public function getInstalment()
    {
        return $this->instalment;
    }

    /**
     * Set paidInstalment
     *
     * @param integer $paidInstalment
     *
     * @return Deal
     */
    public function setPaidInstalment($paidInstalment)
    {
        $this->paidInstalment = $paidInstalment;

        return $this;
    }

    /**
     * Get paidInstalment
     *
     * @return integer
     */
    public function getPaidInstalment()
    {
        return $this->paidInstalment;
    }

    /**
     * Set instalmentValue
     *
     * @param integer $instalmentValue
     *
     * @return Deal
     */
    public function setInstalmentValue($instalmentValue)
    {
        $this->instalmentValue = $instalmentValue;

        return $this;
    }

    /**
     * Get instalmentValue
     *
     * @return integer
     */
    public function getInstalmentValue()
    {
        return $this->instalmentValue;
    }

    /**
     * Set instalments
     *
     * @param integer $instalments
     *
     * @return Deal
     */
    public function setInstalments($instalments)
    {
        $this->instalments = $instalments;

        return $this;
    }

    /**
     * Get instalments
     *
     * @return integer
     */
    public function getInstalments()
    {
        return $this->instalments;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     *
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
     * Set lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     *
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
     * Set date
     *
     * @param \DateTime $date
     *
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
}
