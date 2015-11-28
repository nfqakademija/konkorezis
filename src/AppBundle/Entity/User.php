<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="user")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="UserProduct", mappedBy="user")
     */
    protected $userProducts;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->userProducts = new ArrayCollection();
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Orders $order
     *
     * @return User
     */
    public function addOrder(\AppBundle\Entity\Orders $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Orders $order
     */
    public function removeOrder(\AppBundle\Entity\Orders $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add userProduct
     *
     * @param \AppBundle\Entity\UserProduct $userProduct
     *
     * @return User
     */
    public function addUserProduct(\AppBundle\Entity\UserProduct $userProduct)
    {
        $this->userProducts[] = $userProduct;

        return $this;
    }

    /**
     * Remove userProduct
     *
     * @param \AppBundle\Entity\UserProduct $userProduct
     */
    public function removeUserProduct(\AppBundle\Entity\UserProduct $userProduct)
    {
        $this->userProducts->removeElement($userProduct);
    }

    /**
     * Get userProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserProducts()
    {
        return $this->userProducts;
    }
}
