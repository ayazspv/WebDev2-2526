<?php

namespace App\Models;

use App\Models\OrderStatus;

class Order {
    private int $id;
    private int $userId;
    private float $total_amount;
    private OrderStatus $status;
    private string $created_at;
    /** @var OrderItem[] */
    private array $orderItems;

    public function __construct(
        int $id,
        int $userId,
        float $total_amount,
        OrderStatus $status,
        string $created_at,
        array $orderItems = [] // default empty array
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->total_amount = $total_amount;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->orderItems = $orderItems;
    }

    public function getId(): int { return $this->id; }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $userId): void { $this->userId = $userId; }

    public function getTotalAmount(): float { return $this->total_amount; }
    public function setTotalAmount(float $total_amount): void { $this->total_amount = $total_amount; }

    public function getStatus(): OrderStatus { return $this->status; }
    public function setStatus(OrderStatus $status): void { $this->status = $status; }

    public function getCreatedAt(): string { return $this->created_at; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }

    /**
     * @return OrderItem[]
     */
    public function getOrderItems(): array { 
        return $this->orderItems; 
    }

    /**
     * @param OrderItem[] $orderItems
     */
    public function setOrderItems(array $orderItems): void { 
        $this->orderItems = $orderItems; 
    }

    public function addOrderItem(OrderItem $orderItem): void {
        $this->orderItems[] = $orderItem;
    }

    public function removeOrderItem(int $orderItemId): void {
        foreach ($this->orderItems as $key => $item) {
            if ($item->getId() === $orderItemId) {
                unset($this->orderItems[$key]);
                $this->orderItems = array_values($this->orderItems);
                break;
            }
        }
    }
}
