<?php

namespace App\Services;

interface IOrderItemService {
    public function getAllOrderItems();
    public function addOrderItem($orderItem);
    public function getOrderItemsByOrderId($orderId);
}