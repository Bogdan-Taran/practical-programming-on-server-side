<?php
namespace Src\Auth;

use Src\Session;

class Auth
{
    // Свойство для хранения базового класса-идентификатора
    private static IdentityInterface $userModel;
    // Свойство для хранения текущего аутентифицированного пользователя
    private static ?IdentityInterface $currentUser = null;

    // Инициализация класса пользователя
    public static function init(IdentityInterface $user): void
    {
        self::$userModel = $user;
    }

    // Вход пользователя по модели
    public static function login(IdentityInterface $user): void
    {
        self::$currentUser = $user;
        if (session_id()) {
            Session::set('user_id', $user->getId());
        }
    }

    // Аутентификация пользователя и вход по учетным данным
    public static function attempt(array $credentials): bool
    {
        if ($user = self::$userModel->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    // Возврат текущего аутентифицированного пользователя
    public static function user()
    {
        if (self::$currentUser) {
            return self::$currentUser;
        }
        $id = Session::get('user_id') ?? 0;
        return self::$userModel->findIdentity($id);
    }

    // Проверка является ли текущий пользователь аутентифицированным
    public static function check(): bool
    {
        return self::user() !== null;
    }

    // Выход текущего пользователя
    public static function logout(): bool
    {
        self::$currentUser = null;
        Session::clear('user_id');
        return true;
    }

    // Генерация нового токена для CSRF
    public static function generateCSRF(): string
    {
        $token = md5(time());
        Session::set('csrf_token', $token);
        return $token;
    }
}
