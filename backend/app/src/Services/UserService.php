<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\IUserService;

class UserService implements IUserService {
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function verifyAndGetUser($email, $password)
    {
        return $this->userRepository->login($email, $password);
    }

    public function registerUser($name, $email, $type, $hashedPassword)
    {
        return $this->userRepository->registerUser($name, $email, $type, $hashedPassword);
    }

    public function me($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function addUser($user)
    {
        // Hash password if not already hashed
        if (!empty($user->password) && strlen($user->password) < 60) {
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        }
        return $this->userRepository->addUser($user);
    }

    public function editUser($id, $userData)
    {
        // Convert stdClass to array if necessary
        if (is_object($userData)) {
            $userData = (array)$userData;
        }
        return $this->userRepository->editUser($id, $userData);
    }

    public function deleteUser($userId)
    {
        return $this->userRepository->deleteUser($userId);
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getLatestUser()
    {
        return $this->userRepository->getLatestUser();
    }
}