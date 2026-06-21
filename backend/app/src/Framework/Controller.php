<?php

namespace App\Framework;

use App\Controllers\JWTController;

abstract class Controller
{
    protected $jwtController;

    public function __construct()
    {
        $this->jwtController = new JWTController();
    }

    protected function getUserFromJwt()
    {
        return $this->jwtController->checkForJwt();
    }

    protected function respond($data)
    {
        $this->respondWithCode(200, $data);
    }

    protected function respondWithError($httpCode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpCode, $data);
    }

    protected function respondWithCode($httpCode, $data, bool $pretty = false): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);
        echo json_encode($data, $pretty ? JSON_PRETTY_PRINT : 0);
    }

    protected function getRequestData()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        return $this->sanitize($data);
    }

    protected function sanitize($data)
    {
        if (is_object($data)) {
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $data->$key = htmlspecialchars($value);
                }
            }
        } elseif (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $data[$key] = htmlspecialchars($value);
                }
            }
        }
        return $data;
    }

    /**
     * Maps POST data (JSON) to an instance of the specified class.
     * Note: bypasses sanitize() since it operates on raw input, not getRequestData().
     * Validate/escape values on the receiving end as needed.
     *
     * @param string $className The fully qualified class name
     * @return object|null Returns an instance of the class or null if input is invalid
     */
    protected function mapPostDataToClass(string $className): ?object
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!is_array($data)) {
            return null;
        }

        $instance = new $className();

        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = is_string($value) ? htmlspecialchars($value) : $value;
            }
        }

        return $instance;
    }

}