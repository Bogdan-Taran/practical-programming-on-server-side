<?php
use Model\User;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    //Настройка конфигурации окружения
    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = '/var/www';

        //Подключение bootstrap для инициализации приложения
        require_once __DIR__ . '/../core/bootstrap.php';

        //Создаем экземпляр приложения (если bootstrap не сделал это)
        if (!isset($GLOBALS['app'])) {
            $GLOBALS['app'] = new Src\Application(new Src\Settings([
                'app' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/app.php',
                'db' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/db.php',
                'path' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/path.php',
            ]));
        }

        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }

    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['login'] === 'login is busy') {
            $userData['login'] = User::get()->first()->login;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Site())->signup($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData['login'])->delete();

        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());
    }



//Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        return [
            // Тест GET запроса, ожидаем пустой h3 для сообщения
            ['GET', [],
                '<h3></h3>'
            ],
            // Тест POST запроса с пустыми обязательными полями
            ['POST', [
                'firstname' => '',
                'lastname' => '',
                'patronymic' => '',
                'login' => '',
                'password' => '',
                'academic_degree_id' => ''
            ],
                'Ошибка валидации'
            ],
            // Тест POST запроса с существующим логином
            ['POST', [
                'firstname' => 'Test',
                'lastname' => 'User',
                'patronymic' => 'Patronymic',
                'login' => 'tabdm',
                'password' => 'tabdm',
                'academic_degree_id' => '1'
            ],
                'Поле login должно быть уникально'
            ],
            // Тест успешной регистрации
            ['POST', [
                'firstname' => 'New',
                'lastname' => 'User',
                'patronymic' => 'Newovich',
                'login' => 'newuser_' . md5(time()), // Уникальный логин
                'password' => 'newpassword',
                'academic_degree_id' => '1'
            ],
                'Location: /login'
            ],
        ];
    }

}

