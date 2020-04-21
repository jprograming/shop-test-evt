<?php

namespace App\Managers;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class that manages the related operations with Order entitty.
 * @package App\Managers
 */
class OrderManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Cnstructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generates a pre order from product and quantity.
     * @param Product $product
     * @param int $quantity
     * @param Customer|null $customer
     * @return Order
     */
    public function generatePreOrder(Product $product, int $quantity, Customer $customer = null): Order
    {
        $order = new Order();

        if ($customer) {
            $order->setCustomer($customer);
        }

        $price = $product->getPrice();
        $subtotal = $quantity * $price;
        $detail = new OrderDetail();
        $detail->setProduct($product);
        $detail->setPrice($product->getPrice());
        $detail->setQuantity($quantity);
        $detail->setSubtotal($subtotal);
        $order->addDetail($detail);

        $totalToPay = $subtotal;
        $order->setTotalToPay($totalToPay);

        return $order;
    }

    /**
     * Save a new order.
     * @param Order $order
     */
    public function createOrder(Order $order)
    {
        if ($order->getId()) {
            return;
        }
        // calculate totals
        $detail = $order->getDetails()->first();
        $subtotal = $detail->getQuantity() * $detail->getPrice();
        $detail->setSubtotal($subtotal);
        $totalToPay = $subtotal;
        $order->setTotalToPay($totalToPay);

        // check customer
        $currentCustomer = $order->getCustomer();
        $oldCustomer = $this->entityManager
            ->getRepository(Customer::class)
            ->getCustomerByEmail($currentCustomer->getEmail())
        ;
        if ($oldCustomer) {
            // merge current customer into old customer
            $oldCustomer->setMobile($currentCustomer->getMobile());
            $order->setCustomer($oldCustomer);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    /**
     * @see OrderRepository::getOrderByCode()
     * @param string $code
     * @return Order|null
     */
    public function getOrderByCode(string $code): ?Order
    {
        return $this->entityManager->getRepository(Order::class)->getOrderByCode($code);
    }

    /**
     * Updates the order status.
     * @param Order $order
     * @param string $newStatus
     */
    public function updateOrderStatus(Order $order, string $newStatus)
    {
        $order->setStatus($newStatus);
        $this->entityManager->flush();
    }
}