<?php

namespace App\Repositories;

interface IOrderRepository
{
    public function getAllOrders();
    public function addOrder($order);
    public function getOrderById($id);
    public function getLatestOrder();
    public function getOrdersByUserId($userId);
}