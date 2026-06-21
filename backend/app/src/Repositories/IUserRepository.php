<?php

namespace App\Repositories;

interface IUserRepository {
    public function login($email, $password);
    public function registerUser($name, $email, $type, $hashedPassword);
    public function getUserById($id);
    public function addUser($user);
    public function editUser($id, $userData);
    public function deleteUser($userId);
    public function getAllUsers();
    public function getLatestUser();
}