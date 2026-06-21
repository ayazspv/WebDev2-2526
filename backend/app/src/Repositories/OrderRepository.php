<?php

namespace App\Repositories;

use App\Framework\Repository;

use PDO;

class OrderRepository extends Repository implements IOrderRepository
{

    public function getAllOrders()
    {
        try {
            $stmt = $this->connection->query("SELECT * FROM orders");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function addOrder($order)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO orders (userId, total_amount, status) VALUES (:userId, :total_amount, :status)");
            $stmt->bindParam(':userId', $order->userId);
            $stmt->bindParam(':total_amount', $order->total_amount);
            $stmt->bindParam(':status', $order->status);
            $stmt->execute();
            return $this->getOrderById($this->connection->lastInsertId());
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getOrderById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM orders WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getLatestOrder()
    {
        try {
            $stmt = $this->connection->query("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getOrdersByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM orders WHERE userId = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return [];
        }
    }
}