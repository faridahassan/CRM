<?php
namespace Crm\NotificationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Crm\NotificationBundle\Entity\Notification as Notification;


/**
 * @ORM\Entity
 */
class EventNotification extends Notification {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Crm\SandboxBundle\Entity\Call" )
     * @ORM\JoinColumn(name="call_id", referencedColumnName="id" , onDelete="SET NULL"  )
     */
     protected $event;


     
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
     * @return EventNotification
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
     * @return EventNotification
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
     * @return EventNotification
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
     * @return EventNotification
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
     * Set event
     *
     * @param \Crm\SandboxBundle\Entity\Call $event
     *
     * @return EventNotification
     */
    public function setEvent(\Crm\SandboxBundle\Entity\Call $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Crm\SandboxBundle\Entity\Call
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set toUser
     *
     * @param \Crm\SandboxBundle\Entity\User $toUser
     *
     * @return EventNotification
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
     * @return EventNotification
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
