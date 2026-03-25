<?php
namespace Controller;

use Src\View;
use Illuminate\Database\Capsule\Manager as DB;
class Site
{
    public function index(): string
    {
        $view = new View();
        return $view->render('site.hello', ['message' => 'index working']);

    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}
