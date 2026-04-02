<?php

namespace Controller;

use Model\BAKSpeciality;
use Model\Dissertations;
use Model\DissertationStatus;
use Model\Student;
use Src\Request;
use Src\View;
use Model\DissertationFile;
use Src\Validator\Validator;

class DissertationsController
{
    const UPLOAD_DIR = __DIR__ . '/../../public/uploads/dissertations/';

    public function dissertations(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);
        $error = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']);


        $dissertations = Dissertations::with(['status', 'bakSpeciality', 'student'])->get();
        $searchQuery = $_GET['search-file-query'] ?? '';
        $query = Dissertations::with(['status', 'bakSpeciality', 'student', 'files']);
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('theme', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhereHas('files', function ($fileQuery) use ($searchQuery) {
                        $fileQuery->where('file_name', 'LIKE', '%' . $searchQuery . '%');
                    });
            });
        }
        $dissertations = $query->get();
        $statuses = DissertationStatus::all();
        // Ensure upload directory exists
        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0777, true);
        }
        return new View('site.dissertations', [
            'dissertations' => $dissertations,
            'message' => $message,
            'searchQuery' => $searchQuery, // Pass search query back to the view
            'error' => $error,
            'statuses' => $statuses,
        ]);
    }

    public function addDissertation(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();
            $validator = new Validator($data, [
                'theme' => ['required'],
                'student_id' => ['required'],
                'approval_date' => ['required'],
                'dissertation_status_id' => ['required'],
                'bak_speciality_id' => ['required']
            ], [
                'required' => 'Поле :field не может быть пустым.',
            ]);
            if ($validator->fails()) {
                $_SESSION['error_message'] = implode('<br>', array_reduce($validator->errors(), 'array_merge', []));
                app()->route->redirect('/addDissertation');
                return '';
            }
            $dissertationData = [
                'theme' => $data['theme'],
                'approval_date' => $data['approval_date'],
                'status_id' => $data['dissertation_status_id'],
                'bak_speciality_id' => $data['bak_speciality_id'],
                'student_id' => $data['student_id'],
            ];
            if (Dissertations::create($dissertationData)) {
                $_SESSION['success_message'] = 'Диссертация успешно добавлена!';
                app()->route->redirect('/dissertations');
                return '';
            } else {
                $_SESSION['error_message'] = 'Ошибка при сохранении диссертации в базу данных.';
                app()->route->redirect('/addDissertation');
                return '';
            }
        }
        $bak_specialities = BAKSpeciality::all();
        $statuses = DissertationStatus::all();
//        $students = Student::all();
        $studentsWithDissertations = Dissertations::pluck('student_id')->toArray();
        $students = Student::whereNotIn('student_id', $studentsWithDissertations)->get();
        $errors = [];
        if (isset($_SESSION['error_message'])) {
            $errors = explode('<br>', $_SESSION['error_message']);
            unset($_SESSION['error_message']);
        }
        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);
        return new View('site.add_dissertation', [
            'students' => $students,
            'errors' => $errors,
            'message' => $message,
            'bak_specialities' => $bak_specialities,
            'statuses' => $statuses,
        ]);
    }


    public
    function updateDissertationStatus(Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($request->method === 'POST') {
            $dissertationId = $request->get('dissertation_id');
            $newStatusId = $request->get('dissertation_status_id');

            if (empty($dissertationId) || empty($newStatusId)) {
                $_SESSION['error_message'] = 'Недостаточно данных для обновления статуса диссертации.';
                app()->route->redirect('/dissertations');
                return '';
            }

            $dissertation = Dissertations::find($dissertationId);

            if (!$dissertation) {
                $_SESSION['error_message'] = 'Диссертация не найдена.';
                app()->route->redirect('/dissertations');
                return '';
            }

            $dissertation->status_id = $newStatusId;
            if ($dissertation->save()) {
                $_SESSION['success_message'] = 'Статус диссертации успешно обновлен!';
            } else {
                $_SESSION['error_message'] = 'Ошибка при обновлении статуса диссертации.';
            }
        }
        app()->route->redirect('/dissertations');
        return '';
    }

    public
    function uploadDissertationFile(Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($request->method === 'POST') {
            $dissertationId = $request->get('dissertation_id');
            $file = $_FILES['dissertation_file'] ?? null;

            if (empty($dissertationId) || !$file || $file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error_message'] = 'Произошла ошибка загрузки';
                app()->route->redirect('/dissertations');
                return '';
            }

            $dissertation = Dissertations::find($dissertationId);
            if (!$dissertation) {
                $_SESSION['error_message'] = 'Диссертация не найдена.';
                app()->route->redirect('/dissertations');
                return '';
            }

            $originalFileName = basename($file['name']);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $uniqueFileName = uniqid('dissertation_') . '.' . $fileExtension;
            $targetFilePath = self::UPLOAD_DIR . $uniqueFileName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                // Save file metadata to database
                DissertationFile::create([
                    'dissertation_id' => $dissertationId,
                    'file_name' => $originalFileName,
                    'file_path' => '/uploads/dissertations/' . $uniqueFileName,
                    'file_type' => $file['type'],
                    'file_size' => $file['size'],
                ]);

                $_SESSION['success_message'] = 'Файл успешно загружен!';
            } else {
                $_SESSION['error_message'] = 'Ошибка при сохранении файла на сервере.';
            }
        } else {
            $_SESSION['error_message'] = 'Неверный метод запроса для загрузки файла.';
        }

        app()->route->redirect('/dissertations');
        return '';
    }

}
