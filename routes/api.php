<?php

use Src\Route;

Route::add('GET', '', [Controller\Api::class, 'index']);
Route::add('GET', '/students', [Controller\Api::class, 'students']);
Route::add('GET', '/dissertations', [Controller\Api::class, 'dissertations']);
Route::add('GET', '/publications', [Controller\Api::class, 'publications']);
Route::add('POST', '/echo', [Controller\Api::class, 'echo']);

// Убираем префикс /api, так как он автоматически добавляется в RouteProvider
Route::add('POST', '/login', [Controller\Api::class, 'login']);
Route::add('GET', '/profile', [Controller\Api::class, 'profile'])->middleware('token');
