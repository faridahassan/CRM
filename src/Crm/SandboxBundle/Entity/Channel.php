<?php

namespace Crm\SandboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Channel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crm\SandboxBundle\DAO\ChannelRepository")
 */
class Channel
{
    /**
     * @var integer
     *
     * @ORM\Column(type="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="type", type="string", length=255)
     */
    private $type;

    /**
    * @ORM\OneToMany(targetEntity="SubChannel", mappedBy="channel")
    */
    private $subChannels;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hide", type="boolean")
     */
    private $hide = false;

    public function __construct() {
        $this->subChannels = new ArrayCollection();
    }

    public function __toString() {
        return $this->type;
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
     * Set type
     *
     * @param string $type
     *
     * @return Channel
     */
    public function settype($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function gettype()
    {
        return $this->type;
    }

    /**
     * Add subChannel
     *
     * @param \Crm\SandboxBundle\Entity\SubChannel $subChannel
     *
     * @return Channel
     */
    public function addSubChannel(\Crm\SandboxBundle\Entity\SubChannel $subChannel)
    {
        $this->subChannels[] = $subChannel;

        return $this;
    }

    /**
     * Remove subChannel
     *
     * @param \Crm\SandboxBundle\Entity\SubChannel $subChannel
     */
    public function removeSubChannel(\Crm\SandboxBundle\Entity\SubChannel $subChannel)
    {
        $this->subChannels->removeElement($subChannel);
    }

    /**
     * Get subChannels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubChannels()
    {
        return $this->subChannels;
    }

    /**
     * Set hide
     *
     * @param boolean $hide
     * @return Channel
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
