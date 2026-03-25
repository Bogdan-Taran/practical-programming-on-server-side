<?php
namespace Controller;

use Src\Request;
use Src\View;
use Model\Post;
use Model\User;
use Illuminate\Database\Capsule\Manager as DB;
use Src\Auth\Auth;
class Site
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }
    public function index(): string
    {
        $posts = Post::all();
        return (new View())->render('site.post', ['posts' => $posts]);

    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function signup(Request $request): string
    {
        $userExists = $this->model->checkUserExists($request[1]);
        if($userExists){
            return new View('site.signup', ['message' => 'Такой логин уже есть']);
        }
        else{
            if ($request->method==='POST' && User::create($request -> all())) {
                app()->route->redirect('/go');
                return new View('site.signup', ['message' => 'Успешная рега']);
            }
        }
        return new View('site.signup');

    }
    public function registrationUser(Request $request): string{
        return User::create($request -> all());
    }

}
