<?php
//Включаем запрет на неявное преобразование типов
declare(strict_types=1);
//Включаем запрет на неявное преобразование типов
//Включаем сессии на все страницы
session_start();
// чтобы выплёвывал ошибки
ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

try {
    //Создаем экземпляр приложения и запускаем его
    $app = require_once __DIR__ . '/../core/bootstrap.php';
    $app->run();
} catch (\Throwable $exception) {
    echo '<pre>';
    print_r($exception);
    echo '</pre>';
}
