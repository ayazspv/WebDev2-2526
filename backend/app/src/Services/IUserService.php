<?php

namespace App\Services;

interface IUserService {
    public function verifyAndGetUser($email, $password);
    public function registerUser($name, $email, $type, $hashedPassword);
    public function me($id);
    public function addUser($user);
    public function editUser($id, $userData);
    public function deleteUser($userId);
    public function getAllUsers();
    public function getLatestUser();
}