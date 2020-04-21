<?php

namespace App\Services\PlacetoPay;


use App\Entity\Order;
use App\Managers\OrderManager;
use Symfony\Component\Validator\Exception\LogicException;

/**
 * Class that handle the information request to PlacetoPay plataform.
 * @package App\Services\PlacetoPay
 */
class RequestInformation extends AbstractRequest
{

    /**
     * @var OrderManager
     */
    private $orderManager;

    /**
     * RequestInformation constructor.
     * @param InstanceConfiguration $instance
     * @param OrderManager $orderManager
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function __construct(InstanceConfiguration $instance, OrderManager $orderManager)
    {
        parent::__construct($instance);
        $this->orderManager = $orderManager;
    }

    /**
     * Gets the request information and process the orders updates.
     * @param int $requestId
     * @param Order $order
     */
    public function process(int $requestId, Order $order)
    {
        $response = $this->placetoPay->query($requestId);
        if ($response->isSuccessful()) {
            if ($response->status()->isApproved()) {
                // The payment has been approved
                $this->orderManager->updateOrderStatus($order, Order::PAYED_STATUS);
            } elseif ($response->status()->isRejected()) {
                $this->orderManager->updateOrderStatus($order, Order::REJECTED_STATUS);
            } else {
                throw new LogicException($response->status()->message());
            }
        } else {
            throw new LogicException($response->status()->message());
        }
    }
}