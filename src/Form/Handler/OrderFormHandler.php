<?php

namespace App\Form\Handler;

use App\Entity\Order;
use App\Utils\Manager\OrderManager;

class OrderFormHandler
{
    /**
     * @var OrderManager
     */
    private $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * @param Order $order
     * @return Order|object
     */
    public function processEditForm(Order $order)
    {
        $this->orderManager->recalculateOrderTotalPrice($order);
        $this->orderManager->save($order);

        return $order;
    }
}
