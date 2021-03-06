<?php

namespace App\Entity;

use App\Util\UtilString;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderDetailRepository")
 * @ORM\Table(
 *     name="orders_detail",
 *     uniqueConstraints={
 *        @ORM\UniqueConstraint(
 *            name="order_detail_unique",
 *            columns={"order_id", "product_id"}
 *        )
 *    }
 * )
 */
class OrderDetail
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="details")
     * @ORM\JoinColumn(name="order_id", nullable=false)
     */
    private $orderReference;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $subtotal;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Order|null
     */
    public function getOrderReference(): ?Order
    {
        return $this->orderReference;
    }

    /**
     * @param Order|null $orderReference
     * @return OrderDetail
     */
    public function setOrderReference(?Order $orderReference): self
    {
        $this->orderReference = $orderReference;

        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return OrderDetail
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return OrderDetail
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Returns the price in money format
     * @return string
     */
    public function getFormattedPrice(): string
    {
        return UtilString::getMoneyFormatOrEmpty($this->price);
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return OrderDetail
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    /**
     * @param float $subtotal
     * @return OrderDetail
     */
    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Returns the subtotal in money format
     * @return string
     */
    public function getFormattedSubtotal(): string
    {
        return UtilString::getMoneyFormatOrEmpty($this->subtotal);
    }
}
