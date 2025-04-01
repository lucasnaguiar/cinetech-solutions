<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\AuthService;

class AuthController
{
    public function login()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $user = (new User)->findByEmail(email: $requestData['email']);

        if (!$user || !password_verify($requestData['password'], $user->password)) {
            http_response_code(response_code: 401);
            return json_encode(['error' => 'Credenciais inválidas']);
        }

        $authService = new AuthService();
        $token = $authService->generateToken($user);

        return json_encode(["token" => $token]);
    }
}
