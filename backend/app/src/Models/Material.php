<?php

namespace App\Models;

use App\Models\MaterialStatus;

class Material {
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $quantity;
    private int $seller;
    private MaterialStatus $status;
    private string $location;
    private string $image;
    private string $created_at;

    public function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        int $quantity,
        int $seller,
        MaterialStatus $status,
        string $location,
        string $image,
        string $created_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->seller = $seller;
        $this->status = $status;
        $this->location = $location;
        $this->image = $image;
        $this->created_at = $created_at;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getPrice(): float { return $this->price; }
    public function setPrice(float $price): void { $this->price = $price; }

    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }

    public function getSeller(): int { return $this->seller; }
    public function setSeller(int $seller): void { $this->seller = $seller; }

    public function getStatus(): MaterialStatus { return $this->status; }
    public function setStatus(MaterialStatus $status): void { $this->status = $status; }

    public function getLocation(): string { return $this->location; }
    public function setLocation(string $location): void { $this->location = $location; }

    public function getImage(): string { return $this->image; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getCreatedAt(): string { return $this->created_at; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
}
