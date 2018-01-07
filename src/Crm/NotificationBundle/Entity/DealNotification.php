<?php
namespace Crm\NotificationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Crm\NotificationBundle\Entity\Notification as Notification;


/**
 * @ORM\Entity(repositoryClass="Crm\NotificationBundle\DAO\DealNotificationRepository")
 */
class DealNotification extends Notification {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Crm\SandboxBundle\Entity\Deal" )
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id" , onDelete="SET NULL"  )
     */
     protected $deal;


     
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
     * @return DealNotification
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
     * @return DealNotification
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
     * Set text
     *
     * @param string $text
     *
     * @return DealNotification
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
     * Set seen
     *
     * @param boolean $seen
     *
     * @return DealNotification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set deal
     *
     * @param \Crm\SandboxBundle\Entity\Deal $deal
     *
     * @return DealNotification
     */
    public function setDeal(\Crm\SandboxBundle\Entity\Deal $deal = null)
    {
        $this->deal = $deal;

        return $this;
    }

    /**
     * Get deal
     *
     * @return \Crm\SandboxBundle\Entity\Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * Set toUser
     *
     * @param \Crm\SandboxBundle\Entity\User $toUser
     *
     * @return DealNotification
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

    /**
     * Set system
     *
     * @param boolean $system
     *
     * @return DealNotification
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
}
