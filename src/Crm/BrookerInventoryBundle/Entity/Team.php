<?php

namespace Crm\BrookerInventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Entity(repositoryClass="Crm\BrookerInventoryBundle\DAO\TeamRepository")
 */
class Team
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
     * @ORM\OneToOne(targetEntity="\Crm\SandboxBundle\Entity\User", inversedBy="ledTeam")
     * @ORM\JoinTable(name="fos_user")
     */
    private $leader;

    /**
     * @ORM\OneToMany(targetEntity="\Crm\SandboxBundle\Entity\User", mappedBy="team")
     * @ORM\JoinTable(name="fos_user")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="\Crm\SandboxBundle\Entity\Call", mappedBy="team")
     */
    private $calls;

    /**
     * @ORM\OneToMany(targetEntity="\Crm\SandboxBundle\Entity\Lead", mappedBy="team")
     */
    private $leads;

    /**
     * @ORM\OneToMany(targetEntity="\Crm\SandboxBundle\Entity\Deal", mappedBy="team")
     */
    private $deals;

    public function getCollectiveTargets()
    {
        $total = 0;
        if(!is_null($this->leader))
            $total+= $this->leader->getTarget();
        foreach ($this->users as $member)
            $total+= $member->getTarget();
        return $total;
    }

    public function getProgressedTargets()
    {
        $total = 0;
        foreach ($this->users as $member)
            $total+= $member->getProgressedTarget();
        return $total;
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
     * @return Team
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
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \Crm\SandboxBundle\Entity\User $users
     * @return Team
     */
    public function addUser(\Crm\SandboxBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Crm\SandboxBundle\Entity\User $users
     */
    public function removeUser(\Crm\SandboxBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set leader
     *
     * @param \Crm\SandboxBundle\Entity\User $leader
     * @return Team
     */
    public function setLeader(\Crm\SandboxBundle\Entity\User $leader = null)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * Get leader
     *
     * @return \Crm\SandboxBundle\Entity\User 
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Add calls
     *
     * @param \Crm\SandboxBundle\Entity\Call $calls
     * @return Team
     */
    public function addCall(\Crm\SandboxBundle\Entity\Call $calls)
    {
        $this->calls[] = $calls;

        return $this;
    }

    /**
     * Remove calls
     *
     * @param \Crm\SandboxBundle\Entity\Call $calls
     */
    public function removeCall(\Crm\SandboxBundle\Entity\Call $calls)
    {
        $this->calls->removeElement($calls);
    }

    /**
     * Get calls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCalls()
    {
        return $this->calls;
    }


    /**
     * Add deals
     *
     * @param \Crm\SandboxBundle\Entity\Deal $deals
     * @return Team
     */
    public function addDeal(\Crm\SandboxBundle\Entity\Deal $deals)
    {
        $this->deals[] = $deals;

        return $this;
    }

    /**
     * Remove deals
     *
     * @param \Crm\SandboxBundle\Entity\Deal $deals
     */
    public function removeDeal(\Crm\SandboxBundle\Entity\Deal $deals)
    {
        $this->deals->removeElement($deals);
    }

    /**
     * Get deals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDeals()
    {
        return $this->deals;
    }

    /**
     * Add leads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $leads
     * @return Team
     */
    public function addLead(\Crm\SandboxBundle\Entity\Lead $leads)
    {
        $this->leads[] = $leads;

        return $this;
    }

    /**
     * Remove leads
     *
     * @param \Crm\SandboxBundle\Entity\Lead $leads
     */
    public function removeLead(\Crm\SandboxBundle\Entity\Lead $leads)
    {
        $this->leads->removeElement($leads);
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
}
