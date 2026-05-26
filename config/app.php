<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity'=>\Model\User::class,
    //Классы провайдеров
    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route' => \Providers\RouteProvider::class,
        'db' => \Providers\DBProvider::class,
        'auth' => \Providers\AuthProvider::class,
    ],
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'token' => \Middlewares\TokenMiddleware::class,
    ],
    'validators' => [
        'required' => \PopItMvc\Validator\RequireValidator::class,
        'unique' => \PopItMvc\Validator\UniqueValidator::class
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
    ],
];
