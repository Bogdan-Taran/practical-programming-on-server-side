<?php

namespace Middlewares;

use Closure;
use Model\User;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Проверяем, является ли пользователь администратором
        if (app()->auth::user()->role_id !== User::ROLE_ADMIN) {
            // Если нет, перенаправляем на главную страницу
            app()->route->redirect('/hello');
        }
        // Если проверка пройдена, передаем запрос дальше
        return $next($request);
    }
}