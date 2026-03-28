<?php
namespace Src;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;
use Src\Traits\SingletonTrait;

class Middleware
{
    //Используем трейт
    use SingletonTrait;

    private RouteCollector $middlewareCollector;

    public function add($httpMethod, string $route, array $action): void
    {
        $this->middlewareCollector->addRoute($httpMethod, $route, $action);
    }

    public function group(string $prefix, callable $callback): void
    {
        $this->middlewareCollector->addGroup($prefix, $callback);
    }

    //Конструктор скрыт. Вызывается только один раз
    private function __construct()
    {
        $this->middlewareCollector = new RouteCollector(new Std(), new MarkBased());
    }

    // Запуск всех middlewares для текущего маршрута
    public function go(string $httpMethod, string $uri, Request $request): Request
    {
        // Получаем список всех разрешенных классов middlewares из настроек приложения
        $routeMiddleware = app()->settings->app['routeMiddleware'];
        $middlewares = $this->getMiddlewaresForRoute($httpMethod, $uri);

        // Создаем конвейер (pipeline)
        $pipeline = array_reduce(
            array_reverse($middlewares), // Идем с конца, чтобы вкладывать один в другой
            function ($next, $middlewareName) use ($routeMiddleware) {
                return function (Request $request) use ($next, $middlewareName, $routeMiddleware) {
                    $args = explode(':', $middlewareName);
                    $middlewareClass = $routeMiddleware[$args[0]];
                    $middleware = new $middlewareClass;
                    // Вызываем handle, передавая запрос и следующий шаг ($next)
                    return $middleware->handle($request, $next);
                };
            },
            // Самый последний "next" - это пустая функция, которая просто возвращает запрос
            function (Request $request) {
                return $request;
            }
        );

        // Запускаем конвейер с начальным запросом
        return $pipeline($request);
    }

    //Поиск middlewares по адресу
    private function getMiddlewaresForRoute(string $httpMethod, string $uri): array
    {
        $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
        return $dispatcherMiddleware->dispatch($httpMethod, $uri)[1] ?? [];
    }
}
