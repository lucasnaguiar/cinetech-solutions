<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private $config;

    public function __construct()
    {
        $this->config = include __DIR__ . '/../../config/jwt.php';
    }

    public function generateToken(User $user)
    {
        $payload = [
            'iss' => 'fortuna-api', // Emissor
            'sub' => $user->getId(),    // ID do usuário
            'email' => $user->getEmail(),
            'iat' => time(),
            'exp' => time() + $this->config['expiration'],
        ];

        return JWT::encode($payload, $this->config['secret'], $this->config['algorithm']);
    }

    public function validateToken(string $token)
    {
        try {
            return JWT::decode($token, new Key($this->config['secret'], $this->config['algorithm']));
        } catch (\Exception $e) {
            http_response_code(401);
            return response()->json([
                'errors' => "Token inválido"
            ]);
        }
    }
}
