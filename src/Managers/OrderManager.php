<?php

namespace App\Managers;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderManager
 * @package App\Managers
 */
class OrderManager
{

    /**
     * @var
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
     * @see OrderRepository::getOrderByUrlCode()
     * @param string $urlCode
     * @return mixed
     */
    public function getOrderByUrlCode(string $urlCode)
    {
        return $this->entityManager->getRepository(Order::class)->getOrderByUrlCode($urlCode);
    }
}