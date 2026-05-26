<?php

namespace Middlewares;

use Src\Request;
use Src\Auth\Auth;
use Model\User;
use Src\View;

class TokenMiddleware
{
    public function handle(Request $request): Request
    {
        // Получаем токен из заголовка Authorization
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (strpos($header, 'Bearer ') === 0) {
            $token = substr($header, 7);
            // Ищем пользователя по токену
            $user = User::where('token', $token)->first();
            if ($user) {
                // Если пользователь найден, авторизуем его в системе
                Auth::login($user);
                return $request;
            }
        }

        // Если токен не передан или неверный, возвращаем ошибку
        (new View())->toJSON(['error' => 'Unauthorized'], 401);
        return $request;
    }
}
