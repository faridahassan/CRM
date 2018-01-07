<?php
namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\ComplaintLogRepository")
 * @ORM\Table(name="ComplaintLog")
 */
class ComplaintLog
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    

    /**
    * @ORM\ManyToOne(targetEntity="Complaint", inversedBy="log",cascade={"persist"})
    */
    private $complaint;

    /**
    * //This is the sales rep that is assigned to the lead
    * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedLeads")
    */
    private $user;

    /**
     * @ORM\Column(name="comment", type="text", nullable=true)
    */
    private $comment;

    /**
     * @var string
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    

    /**
     * Constructor
     */
    public function __construct()
    {
        
    }
    public function __toString() {
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
     * Set comment
     *
     * @param string $comment
     * @return ComplaintLog
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
     * Set complaint
     *
     * @param \Crm\SandboxBundle\Entity\Complaint $complaint
     * @return ComplaintLog
     */
    public function setComplaint(\Crm\SandboxBundle\Entity\Complaint $complaint = null)
    {
        $this->complaint = $complaint;

        return $this;
    }

    /**
     * Get complaint
     *
     * @return \Crm\SandboxBundle\Entity\Complaint 
     */
    public function getComplaint()
    {
        return $this->complaint;
    }

    /**
     * Set user
     *
     * @param \Crm\SandboxBundle\Entity\User $user
     * @return ComplaintLog
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
     * Set date
     *
     * @param \DateTime $date
     * @return ComplaintLog
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
