<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Services\IOrderService;

class OrderService implements IOrderService {
    private $orderRepository;

    public function __construct() {
        $this->orderRepository = new OrderRepository();
    }

    public function getAllOrders() {
        return $this->orderRepository->getAllOrders();
    }

    public function addOrder($order) {
        return $this->orderRepository->addOrder($order);
    }

    public function getLatestOrder() {
        return $this->orderRepository->getLatestOrder();
    }
    
    public function getOrdersByUserId($userId) {
        return $this->orderRepository->getOrdersByUserId($userId);
    }
}