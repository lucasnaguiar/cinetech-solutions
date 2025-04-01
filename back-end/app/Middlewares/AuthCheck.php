<?php

namespace App\Middlewares;

use App\Services\AuthService;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthCheck implements IMiddleware
{
	public function handle(Request $request): void
	{
		$authService = new AuthService();

		$token = str_replace('Bearer ', '', $request->getHeader('Authorization'));
		$authService->validateToken($token);
	}
}
