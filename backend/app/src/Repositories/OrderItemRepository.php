<?php

namespace App\Repositories;

use App\Framework\Repository;

use App\Repositories\IOrderItemRepository;
use PDO;

class OrderItemRepository extends Repository implements IOrderItemRepository
{

    public function getAllOrderItems()
    {
        try {
            $stmt = $this->connection->query("SELECT * FROM orderitems");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function addOrderItem($orderItem)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO orderitems (orderId, materialId, quantity, price) VALUES (:orderId, :materialId, :quantity, :price)");
            $stmt->bindParam(':orderId', $orderItem->orderId);
            $stmt->bindParam(':materialId', $orderItem->materialId);
            $stmt->bindParam(':quantity', $orderItem->quantity);
            $stmt->bindParam(':price', $orderItem->price);
            $stmt->execute();
            return $this->getOrderItemById($this->connection->lastInsertId());
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getOrderItemById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM orderitems WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getOrderItemsByOrderId($orderId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM orderitems WHERE orderId = :orderId");
            $stmt->bindParam(':orderId', $orderId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return [];
        }
    }
}