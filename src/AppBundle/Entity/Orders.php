<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Orders
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
     * @var string
     *
     * @ORM\Column(name="supplier_name", type="string", length=255)
     */
    private $supplierName;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_menu_link", type="string", length=255)
     */
    private $supplierMenuLink;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="datetime")
     */
    private $eventDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="joining_deadline", type="datetime")
     */
    private $joiningDeadline;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;


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
     * @return Orders
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
     * Set supplierName
     *
     * @param string $supplierName
     *
     * @return Orders
     */
    public function setSupplierName($supplierName)
    {
        $this->supplierName = $supplierName;

        return $this;
    }

    /**
     * Get supplierName
     *
     * @return string
     */
    public function getSupplierName()
    {
        return $this->supplierName;
    }

    /**
     * Set supplierMenuLink
     *
     * @param string $supplierMenuLink
     *
     * @return Orders
     */
    public function setSupplierMenuLink($supplierMenuLink)
    {
        $this->supplierMenuLink = $supplierMenuLink;

        return $this;
    }

    /**
     * Get supplierMenuLink
     *
     * @return string
     */
    public function getSupplierMenuLink()
    {
        return $this->supplierMenuLink;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Orders
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Orders
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     *
     * @return Orders
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set joiningDeadline
     *
     * @param \DateTime $joiningDeadline
     *
     * @return Orders
     */
    public function setJoiningDeadline($joiningDeadline)
    {
        $this->joiningDeadline = $joiningDeadline;

        return $this;
    }

    /**
     * Get joiningDeadline
     *
     * @return \DateTime
     */
    public function getJoiningDeadline()
    {
        return $this->joiningDeadline;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Orders
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="orders")
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
}

