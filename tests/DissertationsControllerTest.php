<?php

use PHPUnit\Framework\TestCase;
use Controller\DissertationsController;
use Model\Dissertations;
use Model\DissertationFile;
use Model\Student;
use Src\Request;
use Src\Route;

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
    }

    public function testUploadDissertationFile()
    {
        // 1. Подготовка данных
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
        $FileName = 'check.pdf';
        $fakeTempPath = tempnam(sys_get_temp_dir(), 'upl');
        $TempPath = 'C:\Users\Администратор\Downloads\Чек-лист поступающего на бакалавриат 2026-2027.pdf';
        file_put_contents($TempPath, 'Это тестовый PDF файл.');

        $_FILES['dissertation_file'] = [
//            'name' => $fakeFileName,
            'name' => $FileName,
            'tmp_name' => $TempPath,
            'error' => UPLOAD_ERR_OK,
            'size' => filesize($TempPath),
            'type' => 'application/pdf'
        ];

        $request = $this->createMock(Request::class);
        $request->method = 'POST';
        $request->expects($this->any())
            ->method('get')
            ->with('dissertation_id')
            ->willReturn($this->dissertation->dissertation_id);

        // Выполнение тестируемого метода
        // Создаем частичный мок контроллера
        $controller = $this->getMockBuilder(DissertationsController::class)
            ->onlyMethods(['moveUploadedFile']) // Указываем, какой метод будем заменять
            ->getMock();

        $controller->expects($this->once())
            ->method('moveUploadedFile')
            ->willReturn(true);

        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        $controller->uploadDissertationFile($request);

        // Проверка результатов
        $dissertationFile = DissertationFile::where('dissertation_id', $this->dissertation->dissertation_id)->first();
        $this->assertNotNull($dissertationFile, "Запись о файле не была создана в БД.");
        $this->assertEquals($FileName, $dissertationFile->file_name);
        $this->assertEquals('Файл успешно загружен!', $_SESSION['success_message']);
    }

    /*protected function tearDown(): void
    {
        if ($this->dissertation) {
            $dissertationFile = DissertationFile::where('dissertation_id', $this->dissertation->dissertation_id)->first();
            if ($dissertationFile) {
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
    }*/
}
