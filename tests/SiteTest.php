<?php

use Controller\Site;
use Model\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Request;
use Src\Route;

class SiteTest extends TestCase
{

    //Настройка конфигурации окружения
    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = 'C:/ProgramData/OSPanel/home/pop-it-mvc';

        //Создаем экземпляр приложения
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
        ]));

        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }


    #[DataProvider('additionProvider')]
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if (isset($userData['login']) && $userData['login'] === 'tabdm') {
            $userData['login'] = User::get()->first()->login;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new Site())->signup($request);

        // Проверяем, был ли возвращен результат (ошибка валидации или GET-запрос)
        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $this->assertStringContainsString($message, $result);
            return;
        }

        // Если метод вернул пустой результат, значит, это успешная регистрация
        // Проверяем, что пользователь действительно был создан
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData['login'])->delete();

        // Проверяем, что в случае успеха возвращается пустой результат
        $this->assertEmpty($result);
    }


//Метод, возвращающий набор тестовых данных
    public static function additionProvider(): array
    {
        return [
            'GET request shows form' =>
            ['GET', [
                'firstname' => '', 'lastname' => '', 'patronymic' => '',
                'login' => '', 'password' => '', 'role_id' => '', 'academic_degree_id' => '',
            ], '<h1>Регистрация нового пользователя</h1>'],

            'POST with empty firstname' =>
            ['POST', [
                'firstname' => '', 'lastname' => '', 'patronymic' => '',
                'login' => '', 'password' => '', 'role_id' => '', 'academic_degree_id' => '',
            ], 'Поле firstname пусто'],

            'POST with existing login' =>
            ['POST', [
                'firstname' => 'Богдан', 'lastname' => 'Таран', 'patronymic' => 'Дмитриевич',
                'login' => 'tabdm', 'password' => 'tabdm', 'role_id' => '2', 'academic_degree_id' => '2'
            ], 'Поле login должно быть уникально'],

            'Successful registration' =>
            ['POST', [
                'firstname' => 'Чебурашка', 'lastname' => 'Шапокляк', 'patronymic' => 'Геннадьевич',
                'login' => 'cheburashka_' . time(), 'password' => 'admin', 'role_id' => '2', 'academic_degree_id' => '2'
            ], ''],
        ];
    }

}
