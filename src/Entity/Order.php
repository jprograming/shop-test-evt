<?php

namespace App\Entity;

use App\Util\UtilString;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\EntityListeners({"App\Listeners\OrderListener"})
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="orders")
 */
class Order
{

    const CREATED_STATUS = 'CREATED';

    const PAYED_STATUS = 'PAYED';

    const REJECTED_STATUS = 'REJECTED';

    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $code;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $totalToPay;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @var OrderDetail
     * @ORM\OneToMany(
     *     targetEntity="OrderDetail",
     *     mappedBy="orderReference",
     *     cascade={"persist"},
     *     orphanRemoval=true,
     *     fetch="EXTRA_LAZY"
     * )
     */
    private $details;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setStatus(self::CREATED_STATUS);
        $this->details = new ArrayCollection();
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
     * @param string $urlCode
     * @return Order
     */
    public function setUrlCode(string $urlCode): self
    {
        $this->urlCode = $urlCode;

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
     * Returns the total to pay in money format
     * @return string
     */
    public function getFormattedTotalToPay(): string
    {
        return UtilString::getMoneyFormatOrEmpty($this->totalToPay);
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

    /**
     * @return Collection|null
     */
    public function getDetails(): ?Collection
    {
        return $this->details;
    }

    /**
     * @param OrderDetail $detail
     * @return Order
     */
    public function addDetail(OrderDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $detail->setOrderReference($this);
            $this->details[] = $detail;
        }

        return $this;
    }

    /**
     * @param OrderDetail $detail
     * @return Order
     */
    public function removeDetail(OrderDetail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
        }

        return $this;
    }
}
