<?php 

namespace App\Controllers;

class JWTController {

    public function generateJWT($user)
    {
        $secret_key = "a8f5f167f44f4964e6c998dee827110c8c5e6b3f8a1d2c3e4f5061728394a5b";
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $user->getFirstname() . ' ' . $user->getLastname()
            ]
        ];
    
        return \Firebase\JWT\JWT::encode($payload, $secret_key, 'HS256');
    }

    public function checkForJwt()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            throw new \RuntimeException('Authorization token is missing', 401);
        }
 
        $authHeader = $headers['Authorization'];
        $token = str_replace('Bearer ', '', $authHeader);
 
        try {
            $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key('VERY_TOP_SECRET', 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            throw new \RuntimeException('Invalid or expired token', 401);
        }
    }
}