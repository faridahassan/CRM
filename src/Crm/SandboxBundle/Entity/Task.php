<?php

namespace Crm\SandboxBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="comment", type="string",nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     */
    private $user;

     /**
     * @ORM\OneToOne(targetEntity="Call", inversedBy="task")
     */
    private $call;

    /**
     * @ORM\ManyToOne(targetEntity="Lead", inversedBy="tasks")
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
     * @ORM\Column(name="cancel_date", type="datetime", nullable=true)
     */
    private $cancelDate;
    /**
     * @var date
     * @ORM\Column(name="reason", type="string", length=255 , nullable = true)
     */
    private $reason;
    /**
     * @var date
     * @ORM\Column(name="done", type="boolean")
     */
    private $done = false;

    /**
     * @var date
     * @ORM\Column(name="canceled", type="boolean")
     */
    private $canceled = false;

    /**
     * @var date
     * @ORM\Column(name="postponed", type="boolean")
     */
    private $postponed = false;



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
     * Set comment
     *
     * @param string $comment
     * @return Task
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Task
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
     * Set date
     *
     * @param \DateTime $date
     * @return Task
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
     * @return Task
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
     * @return Task
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
     * Set call
     *
     * @param \Crm\SandboxBundle\Entity\Call $call
     * @return Task
     */
    public function setCall(\Crm\SandboxBundle\Entity\Call $call = null)
    {
        $this->call = $call;

        return $this;
    }

    /**
     * Get call
     *
     * @return \Crm\SandboxBundle\Entity\Call 
     */
    public function getCall()
    {
        return $this->call;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return Task
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set postponed
     *
     * @param boolean $postponed
     * @return Task
     */
    public function setPostponed($postponed)
    {
        $this->postponed = $postponed;

        return $this;
    }

    /**
     * Get postponed
     *
     * @return boolean 
     */
    public function getPostponed()
    {
        return $this->postponed;
    }

    /**
     * Set canceled
     *
     * @param boolean $canceled
     * @return Task
     */
    public function setCanceled($canceled)
    {
        $this->canceled = $canceled;

        return $this;
    }

    /**
     * Get canceled
     *
     * @return boolean 
     */
    public function getCanceled()
    {
        return $this->canceled;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return Task
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set cancelDate
     *
     * @param \DateTime $cancelDate
     * @return Task
     */
    public function setCancelDate($cancelDate)
    {
        $this->cancelDate = $cancelDate;

        return $this;
    }

    /**
     * Get cancelDate
     *
     * @return \DateTime 
     */
    public function getCancelDate()
    {
        return $this->cancelDate;
    }
}
