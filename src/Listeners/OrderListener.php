<?php

namespace App\Listeners;


use App\Entity\Order;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * Subscribe and execute events associated with the Order entity.
 * @package App\Listeners
 */
class OrderListener implements EventSubscriber
{

    /**
     *
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return ['postPersist'];
    }


    /**
     * @param Order $order
     * @param LifecycleEventArgs $args
     */
    public function postPersist(Order $order, LifecycleEventArgs $args)
    {
        $code = str_pad("{$order->getId()}",  10, "0", STR_PAD_LEFT);
        $order->setCode($code);
        $entityManager = $args->getObjectManager();
        $entityManager->flush();
    }
}
