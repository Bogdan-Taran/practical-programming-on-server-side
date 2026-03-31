<?php
namespace Controller;

use Model\AcademicDegree;
use Model\Post;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

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
        // Проверяем наличие флеш-сообщения
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);

        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login', ['message' => $message]);
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
            return '';
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        $message = 'Неправильные логин или пароль';
        return new View('site.login', ['message' => $message, 'error' => true]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'firstname' => ['required'],
                'lastname' => ['required'],
                'patronymic' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'academic_degree_id' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            
            if($validator->fails()){
                return new View('site.signup', [
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка валидации'
                ]);
            }

            $data = $request->all();

            // Переименовываем ключ пароля для соответствия полю в БД
            $data['password_hash'] = $data['password'];


            if (User::create($data)) {
                // Устанавливаем флеш-сообщение
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['success_message'] = 'Вы успешно зарегистрированы!';
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function adminPanel(): string
    {
        $users = User::all();
        return new View('site.admin_panel', ['users' => $users]);
    }



    public function redirectToHello(): void
    {
        app()->route->redirect('/hello');
    }

}
