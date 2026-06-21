<?php

namespace App\Services;
    
interface IOrderService {
    public function getAllOrders();
    public function addOrder($order);
    public function getLatestOrder();
    public function getOrdersByUserId($userId);
}