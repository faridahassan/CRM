<?php
namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\DatabaseRepository")
 * @ORM\Table(name="database_table")
 */
class Database
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\OneToMany(targetEntity="Contact", mappedBy="database")
    */
    private $contacts;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
    * //This is the user that created the lead
    * @ORM\ManyToOne(targetEntity="User", inversedBy="databases")
    */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Database
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
     * Add contact
     *
     * @param \Crm\SandboxBundle\Entity\Contact $contact
     *
     * @return Database
     */
    public function addContact(\Crm\SandboxBundle\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \Crm\SandboxBundle\Entity\Contact $contact
     */
    public function removeContact(\Crm\SandboxBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set user
     *
     * @param \Crm\SandboxBundle\Entity\User $user
     * @return Database
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
}
