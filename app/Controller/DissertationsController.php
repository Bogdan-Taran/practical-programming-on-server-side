<?php

namespace Controller;
use Model\BAKSpeciality;
use Model\Dissertations;
use Model\DissertationStatus;
use Model\Student;
use Model\User;
use Src\Request;
use Src\View;


class DissertationsController
{
    public function dissertations(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);
        $error = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']);

        //$dissertations = Dissertations::all();
        $dissertations = Dissertations::with(['status', 'bakSpeciality', 'student'])->get();
        $statuses = DissertationStatus::all();
        return new View('site.dissertations', [
            'dissertations' => $dissertations,
            'message' => $message,
            'error' => $error,
            'statuses' => $statuses,
        ]);
    }

    public function addDissertation(Request $request): string
    {
        $errors = [];
        $message = '';

        if ($request->method === 'POST') {
            $data = $request->all();

            // Basic validation
            if (empty($data['theme'])) {
                $errors[] = 'Тема диссертации не может быть пустой.';
            }
            if (empty($data['student_id'])) {
                $errors[] = 'Необходимо выбрать студента.';
            }
            if (empty($data['approval_date'])) {
                $errors[] = 'Дата утверждения не может быть пустой.';
            }
            if (empty($data['dissertation_status_id'])) {
                $errors[] = 'Необходимо выбрать статус диссертации.';
            }
            if (empty($data['bak_speciality_id'])) {
                $errors[] = 'Необходимо выбрать специальность ВАК.';
            }

            if (empty($errors)) {
                $dissertationData = [
                    'theme' => $data['theme'],
                    'approval_date' => $data['approval_date'],
                    'status_id' => $data['dissertation_status_id'],
                    'bak_speciality_id' => $data['bak_speciality_id'],
                    'student_id' => $data['student_id'],
                ];

                if (Dissertations::create($dissertationData)) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['success_message'] = 'Диссертация успешно добавлена!';
                    app()->route->redirect('/dissertations');
                    return '';
                } else {
                    $errors[] = 'Ошибка при сохранении диссертации в базу данных.';
                }
            }
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = implode('<br>', $errors);
            app()->route->redirect('/addDissertation');
            return '';
        }
        $bak_specialities = BAKSpeciality::all();
        $statuses = DissertationStatus::all();
        $students = Student::all();
        return new View('site.add_dissertation', [
            'students' => $students,
            'errors' => $errors,
            'message' => $message,
            'bak_specialities' => $bak_specialities,
            'statuses' => $statuses,

        ]);
    }

    public function updateDissertationStatus(Request $request){
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

}
