<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function login()
    {
        $credentials = $this->getRequestData();
        try {
            $user = $this->userService->verifyAndGetUser($credentials->email, $credentials->password);
        } catch (\PDOException $e) {
            $this->respondWithError(401, $e->getMessage());
            return;
        }
        if (empty($user)) {
            $this->respondWithError(401, "Invalid Password Try Again");
            return;
        }

        // Generate JWT token
        $token = $this->jwtController->generateJWT($user);

        // Prepare response payload
        $response = [
            'success' => true,
            'id' => $user->getId(),
            'token' => $token,
            'userEmail' => $user->getEmail(),
            'userType' => $user->getRole()->value // <-- fix here
        ];

        // Respond with the payload
        $this->respond($response);
    }

    public function register()
    {
        try {
            // Retrieve and decode JSON payload
            $data = json_decode(file_get_contents('php://input'), true);

            // Validate input
            if (!isset($data['name']) || !isset($data['email']) || !isset($data['type']) || !isset($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'errors' => ['other' => 'Name, email, type, and password are required']]);
                return;
            }

            $name = $data['name'];
            $email = $data['email'];
            $type = $data['type'];
            $password = $data['password'];

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = $this->userService->registerUser($name, $email, $type, $hashedPassword);

            if ($user) {
                http_response_code(201); // Created
                echo json_encode(['success' => true, 'message' => 'User registered successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'errors' => ['other' => 'Failed to register user']]);
            }
        } catch (\Exception $e) {
            error_log("Exception in register: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'errors' => ['other' => 'An unexpected error occurred']]);
        }
    }

    public function me()
    {
        $jwt = $this->getUserFromJwt();
        $userId = $jwt->data->id ?? null;
        if (!$userId) {
            $this->respondWithError(401, "Invalid token");
            return;
        }
        try {
            $userData = $this->userService->me($userId);
            if ($userData) {
                // Respond with a clean user object (avoid sending password)
                $this->respond([
                    'id' => $userData->getId(),
                    'firstname' => $userData->getFirstname(),
                    'lastname' => $userData->getLastname(),
                    'email' => $userData->getEmail(),
                    'role' => $userData->getRole()->value,
                    'phoneNumber' => $userData->getPhoneNumber(),
                    'status' => $userData->getStatus()->value,
                ]);
            } else {
                $this->respondWithError(404, "User not found");
            }
        } catch (\PDOException $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function addUser()
    {
        $user = $this->getUserFromJwt();
        try {
            $data = $this->getRequestData();

            // Validate required fields
            $required = ['firstname', 'lastname', 'role', 'email', 'password', 'phoneNumber', 'status'];
            foreach ($required as $field) {
                if (empty($data->$field)) {
                    $this->respondWithError(400, "Missing field: $field");
                    return;
                }
            }

            $result = $this->userService->addUser($data);
            if ($result) {
                $this->respond(['success' => true, 'user' => $result]);
            } else {
                $this->respondWithError(500, "Failed to add user");
            }
        } catch (\PDOException $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function editUser($id)
    {
        $user = $this->getUserFromJwt();
        try {
            $data = $this->getRequestData();
            $result = $this->userService->editUser($id, $data);
            if ($result) {
                $this->respond(['success' => true]);
            } else {
                $this->respondWithError(500, "Failed to update user");
            }
        } catch (\PDOException $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        $user = $this->getUserFromJwt();
        try {
            $result = $this->userService->deleteUser($id);
            if ($result) {
                $this->respond(['success' => true]);
            } else {
                $this->respondWithError(500, "Failed to delete user");
            }
        } catch (\PDOException $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getAllUsers()
    {
        // $user = $this->getUserFromJwt();
        $users = $this->userService->getAllUsers();
        $this->respond($users);
    }

    public function getLatestUser()
    {
        $user = $this->getUserFromJwt();
        try {
            $user = $this->userService->getLatestUser();
            if ($user) {
                $this->respond($user);
            } else {
                $this->respondWithError(404, "No users found");
            }
        } catch (\PDOException $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }


    public function test(...$args)
    {
        $this->respond(['message' => '✅ It works!']);
    }
}
