<?php

use PHPUnit\Framework\TestCase;
use Controller\DissertationsController;
use Model\Dissertations;
use Model\DissertationFile;
use Model\Student;
use Src\Request;

class DissertationsControllerTest extends TestCase
{
    private $student;
    private $dissertation;

    protected function setUp(): void
    {
        // Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = 'C:/ProgramData/OSPanel/home/pop-it-mvc';

        // Создаем экземпляр приложения
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
        ]));

        // Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }

        // Убедимся, что директория для загрузок существует
        if (!is_dir(DissertationsController::UPLOAD_DIR)) {
            mkdir(DissertationsController::UPLOAD_DIR, 0777, true);
        }
    }

    public function testUploadDissertationFile()
    {
        // 1. Подготовка данных для теста
        $this->student = Student::create([
            'firstname' => 'Тест',
            'lastname' => 'Тестов',
            'patronymic' => 'Тестович' . time(),
            'specialization_id' => 1,
            'group_id' => 1,
            'scientific_supervisor_id' => 4,
        ]);

        $this->dissertation = Dissertations::create([
            'theme' => 'Тестовая тема для загрузки файла',
            'approval_date' => '2001-09-11',
            'status_id' => 1,
            'bak_speciality_id' => 1,
            'student_id' => $this->student->student_id,
        ]);

        $fakeFileName = 'test_dissertation.pdf';
        $fakeTempPath = tempnam(sys_get_temp_dir(), 'upl');
        file_put_contents($fakeTempPath, 'Это тестовый PDF файл.');

        $_FILES['dissertation_file'] = [
            'name' => $fakeFileName,
            'tmp_name' => $fakeTempPath,
            'error' => UPLOAD_ERR_OK,
            'size' => filesize($fakeTempPath),
            'type' => 'application/pdf'
        ];

        $request = $this->createMock(Request::class);
        $request->method = 'POST';
        $request->expects($this->any())
            ->method('get')
            ->with('dissertation_id')
            ->willReturn($this->dissertation->dissertation_id);

        // 2. Выполнение тестируемого метода
        // Создаем частичный мок контроллера
        $controller = $this->getMockBuilder(DissertationsController::class)
            ->onlyMethods(['moveUploadedFile']) // Указываем, какой метод будем заменять
            ->getMock();

        // "Обучаем" мок: наш новый метод всегда должен возвращать true
        $controller->expects($this->once())
            ->method('moveUploadedFile')
            ->willReturn(true);

        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        
        // Вызываем метод, который теперь будет использовать нашу "поддельную" реализацию moveUploadedFile
        $controller->uploadDissertationFile($request);

        // 3. Проверка результатов
        $dissertationFile = DissertationFile::where('dissertation_id', $this->dissertation->dissertation_id)->first();
        $this->assertNotNull($dissertationFile, "Запись о файле не была создана в БД.");
        $this->assertEquals($fakeFileName, $dissertationFile->file_name);
        
        // Так как мы имитировали загрузку, файла на диске не будет. Проверять его наличие не нужно.
        // $this->assertFileExists(...) - эта строка теперь не нужна

        $this->assertEquals('Файл успешно загружен!', $_SESSION['success_message']);
    }

    protected function tearDown(): void
    {
        if ($this->dissertation) {
            $dissertationFile = DissertationFile::where('dissertation_id', $this->dissertation->dissertation_id)->first();
            if ($dissertationFile) {
                // Поскольку в этом тесте мы мокируем загрузку, реального файла не создается.
                $dissertationFile->delete();
            }
            $this->dissertation->delete();
        }

        if ($this->student) {
            $this->student->delete();
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION['success_message']);
        }

        parent::tearDown();
    }
}
