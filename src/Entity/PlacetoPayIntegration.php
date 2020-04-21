<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlacetoPayIntegrationRepository")
 */
class PlacetoPayIntegration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $requestId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $processUrl;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderCode;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getRequestId(): ?int
    {
        return $this->requestId;
    }

    /**
     * @param int $requestId
     * @return PlacetoPayIntegration
     */
    public function setRequestId(int $requestId): self
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProcessUrl(): ?string
    {
        return $this->processUrl;
    }

    /**
     * @param string $processUrl
     * @return PlacetoPayIntegration
     */
    public function setProcessUrl(string $processUrl): self
    {
        $this->processUrl = $processUrl;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return PlacetoPayIntegration
     */
    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOrderCode(): ?string
    {
        return $this->orderCode;
    }

    /**
     * @param string $orderCode
     * @return PlacetoPayIntegration
     */
    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }
}
