<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Product
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=8, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

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
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Product
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="products")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="UserProduct", mappedBy="product")
     */
    protected $userProducts;

    public function __construct()
    {
        $this->userProducts = new ArrayCollection();
    }

    /**
     * Set orders
     *
     * @param \AppBundle\Entity\Orders $orders
     *
     * @return Product
     */
    public function setOrders(\AppBundle\Entity\Orders $orders = null)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return \AppBundle\Entity\Orders
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
     * @return Product
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
