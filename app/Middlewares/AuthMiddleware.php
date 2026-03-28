<?php

namespace Middlewares;

use Src\Auth\Auth;
use Closure;
use Src\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //Если пользователь не авторизован, то редирект на страницу входа
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }
        //Если проверка пройдена, то передаем запрос дальше
        return $next($request);
    }
}
