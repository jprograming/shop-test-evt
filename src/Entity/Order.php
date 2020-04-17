<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{

    const CREATED_STATUS = 'CREATED';

    const PAYED_STATUS = 'PAYED';

    const REJECTED_STATUS = 'REJECTED';

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="guid")
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="float")
     */
    private $totalToPay;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setStatus(self::CREATED_STATUS);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Order
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return Order
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTotalToPay(): ?float
    {
        return $this->totalToPay;
    }

    /**
     * @param float $totalToPay
     * @return Order
     */
    public function setTotalToPay(float $totalToPay): self
    {
        $this->totalToPay = $totalToPay;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Order
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
