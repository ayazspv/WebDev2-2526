<?php

namespace App\Repositories;

use App\Models\OrderItem;

interface IOrderItemRepository
{
    public function getAllOrderItems();
    public function addOrderItem($orderItem);
    public function getOrderItemById($id);
    public function getOrderItemsByOrderId($orderId);
}