<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * SubChannel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\SubChannelRepository")
 */
class SubChannel
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
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost = 0;

    /**
    * @ORM\OneToMany(targetEntity="Lead", mappedBy="subChannel")
    */
    private $leads;

    /**
     * @var date
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var date
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hide", type="boolean")
     */
    private $hide = false;

    public function __construct() {
        $this->leads = new ArrayCollection();
    }

    /**
    * @ORM\ManyToOne(targetEntity="Channel", inversedBy="subChannels")
    */
    private $channel;

    public function __toString() {
        if(!is_null($this->channel)){
            return $this->channel->getType() . ' - ' . $this->name;
        }
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
     *
     * @return SubChannel
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return SubChannel
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return SubChannel
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Add lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     *
     * @return SubChannel
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
     * Set channel
     *
     * @param \Crm\SandboxBundle\Entity\Channel $channel
     *
     * @return SubChannel
     */
    public function setChannel(\Crm\SandboxBundle\Entity\Channel $channel = null)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return \Crm\SandboxBundle\Entity\Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     * @return SubChannel
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set hide
     *
     * @param boolean $hide
     * @return SubChannel
     */
    public function setHide($hide)
    {
        $this->hide = $hide;

        return $this;
    }

    /**
     * Get hide
     *
     * @return boolean 
     */
    public function getHide()
    {
        return $this->hide;
    }
}
