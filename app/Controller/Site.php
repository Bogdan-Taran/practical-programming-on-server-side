<?php
namespace Controller;

use Src\View;
use Model\Post;
use Illuminate\Database\Capsule\Manager as DB;
class Site
{
    public function index(): string
    {
        $posts = Post::all();
        return (new View())->render('site.post', ['posts' => $posts]);

    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}
