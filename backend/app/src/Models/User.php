<?php

namespace App\Models;

use App\Models\UserRole;
use App\Models\UserStatus;

class User {
    private int $id;
    private string $firstname;
    private string $lastname;
    private UserRole $role;
    private string $email;
    private string $password;
    private ?string $phoneNumber;
    private UserStatus $status;

    public function __construct(
        int $id,
        string $firstname,
        string $lastname,
        UserRole $role,
        string $email,
        string $password,
        ?string $phoneNumber,
        UserStatus $status
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
        $this->email = $email;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->status = $status;
    }

    public function getId(): int { return $this->id; }
    public function getFirstname(): string { return $this->firstname; }
    public function setFirstname(string $firstname): void { $this->firstname = $firstname; }

    public function getLastname(): string { return $this->lastname; }
    public function setLastname(string $lastname): void { $this->lastname = $lastname; }

    public function getRole(): UserRole { return $this->role; }
    public function setRole(UserRole $role): void { $this->role = $role; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function setPhoneNumber(?string $phoneNumber): void { $this->phoneNumber = $phoneNumber; }

    public function getStatus(): UserStatus { return $this->status; }
    public function setStatus(UserStatus $status): void { $this->status = $status; }
}
