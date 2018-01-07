<?php
namespace Crm\NotificationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Crm\NotificationBundle\Entity\Notification as Notification;


/**
 * @ORM\Entity
 */
class LeadNotification extends Notification {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Crm\SandboxBundle\Entity\Lead",cascade={"persist"})
     * @ORM\JoinColumn(name="lead_id", referencedColumnName="id" , onDelete="SET NULL"  )
     */
     protected $lead;
   
     /**
     * 
     * @ORM\ManyToOne(targetEntity="Crm\SandboxBundle\Entity\User", inversedBy="notifyby" )
     * @ORM\JoinColumn(name="fromuser_id", referencedColumnName="id" , onDelete="SET NULL"   )
     */
     protected $fromUser;

     
      /**
     * Constructor
     */
    public function __construct()
    {
        
        $this->setCreated(new \DateTime());
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return ReplyNotification
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ReplyNotification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set seen
     *
     * @param string $seen
     *
     * @return ReplyNotification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return string
     */
    public function getSeen()
    {
        return $this->seen;
    }

   
    /**
     * Set text
     *
     * @param string $text
     *
     * @return ReplyNotification
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set lead
     *
     * @param \Crm\SandboxBundle\Entity\Lead $lead
     *
     * @return LeadNotification
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
     * Set system
     *
     * @param boolean $system
     *
     * @return LeadNotification
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return boolean
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Set fromUser
     *
     * @param \Crm\SandboxBundle\Entity\User $fromUser
     * @return LeadNotification
     */
    public function setFromUser(\Crm\SandboxBundle\Entity\User $fromUser = null)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set toUser
     *
     * @param \Crm\SandboxBundle\Entity\User $toUser
     * @return LeadNotification
     */
    public function setToUser(\Crm\SandboxBundle\Entity\User $toUser = null)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getToUser()
    {
        return $this->toUser;
    }
}
