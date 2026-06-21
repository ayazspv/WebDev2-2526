<?php

namespace App\Models;

class OrderItem {
    private int $id;
    private int $orderId;
    private int $materialId;
    private int $quantity;
    private float $price;

    public function __construct(
        int $id,
        int $orderId,
        int $materialId,
        int $quantity,
        float $price
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->materialId = $materialId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getId(): int { return $this->id; }
    public function getOrderId(): int { return $this->orderId; }
    public function setOrderId(int $orderId): void { $this->orderId = $orderId; }

    public function getMaterialId(): int { return $this->materialId; }
    public function setMaterialId(int $materialId): void { $this->materialId = $materialId; }

    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }

    public function getPrice(): float { return $this->price; }
    public function setPrice(float $price): void { $this->price = $price; }
}
