<?php

namespace App\Managers;
use App\Entity\Order;
use App\Entity\PlacetoPayIntegration;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class that manages the related operations with PlacetoPayIntegration entity.
 * @package App\Managers
 */
class PlacetoPayIntegrationManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create a new record for the PlacetoPay intregation
     * @param Order $order
     * @param int $requestId
     * @param string $processUrl
     */
    public function createRecord(Order $order, int $requestId, string $processUrl)
    {
        $ppIntegration = new PlacetoPayIntegration();
        $ppIntegration->setOrderId($order->getId());
        $ppIntegration->setOrderCode($order->getCode());
        $ppIntegration->setRequestId($requestId);
        $ppIntegration->setProcessUrl($processUrl);

        $this->entityManager->persist($ppIntegration);
        $this->entityManager->flush();
    }
}