<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;
use App\Services\IOrderItemService;

class OrderItemService implements IOrderItemService {
    private $orderItemRepository;

    public function __construct() {
        $this->orderItemRepository = new OrderItemRepository();
    }

    public function getAllOrderItems() {
        return $this->orderItemRepository->getAllOrderItems();
    }

    public function addOrderItem($orderItem) {
        return $this->orderItemRepository->addOrderItem($orderItem);
    }

    public function getOrderItemsByOrderId($orderId) {
        return $this->orderItemRepository->getOrderItemsByOrderId($orderId);
    }
}