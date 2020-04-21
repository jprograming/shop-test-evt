<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\PlacetoPayIntegration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlacetoPayIntegration|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlacetoPayIntegration|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlacetoPayIntegration[]    findAll()
 * @method PlacetoPayIntegration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlacetoPayIntegrationRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlacetoPayIntegration::class);
    }

    /**
     * Returns a record by order.
     * @param Order $order
     * @return PlacetoPayIntegration|null
     */
    public function getRecordByOrder(Order $order): ?PlacetoPayIntegration
    {
        return $this->findOneBy([
            'orderId' => $order->getId(),
            'orderCode' => $order->getCode()
        ]);
    }
}
