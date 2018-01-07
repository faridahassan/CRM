<?php
namespace Crm\NotificationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use Crm\NotificationBundle\Entity\Notification as Notification;


/**
 * @ORM\Entity(repositoryClass="Crm\NotificationBundle\DAO\PropertyNotificationRepository")
 */
class PropertyNotification extends Notification {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Crm\BrookerInventoryBundle\Entity\Property" )
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id" , onDelete="SET NULL"  )
     */
     protected $property;


     
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
     * @return PropertyNotification
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
     * @return PropertyNotification
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
     * @return PropertyNotification
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
     * @return PropertyNotification
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
     * Set property
     *
     * @param \Crm\BrookerInventoryBundle\Entity\Property $property
     *
     * @return PropertyNotification
     */
    public function setProperty(\Crm\BrookerInventoryBundle\Entity\Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return \Crm\BrookerInventoryBundle\Entity\Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set toUser
     *
     * @param \Crm\SandboxBundle\Entity\User $toUser
     *
     * @return PropertyNotification
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
     * @return PropertyNotification
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
