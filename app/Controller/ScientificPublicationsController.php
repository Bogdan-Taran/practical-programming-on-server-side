<?php

namespace Controller;

use Model\Editions;
use Model\Indexes;
use Model\ScientificPublications;
use Model\Student;
use Src\Request;
use Src\View;

class ScientificPublicationsController
{
    public function ScientificPublications()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);
        $error = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']);

        $scientific_publications = ScientificPublications::with(['edition', 'index', 'student'])->get();
        $editions = Editions::all();
        $indexes = Indexes::all();
        $students = Student::all();
        return (new View())->render('site.scientific_publications',
            [
                'editions' => $editions,
                'indexes' => $indexes,
                'students' => $students,
                'scientific_publications' => $scientific_publications,
                'message' => $message,
                'error' => $error,
            ]);
    }

    public function addScientificPublication(Request $request): string
    {
        $errors = [];
        $message = '';

        if ($request->method === 'POST') {
            $data = $request->all();

            // Validation
            if (empty($data['name'])) {
                $errors[] = 'Название научной публикации не может быть пустым.';
            }
            if (empty($data['edition_id'])) {
                $errors[] = 'Необходимо выбрать издание.';
            }
            if (empty($data['publication_date'])) {
                $errors[] = 'Дата публикации не может быть пустой.';
            }
            if (empty($data['index_id'])) {
                $errors[] = 'Необходимо выбрать индекс.';
            }
            if (empty($data['student_id'])) {
                $errors[] = 'Необходимо выбрать студента.';
            }

            if (empty($errors)) {
                $scientificPublicationData = [
                    'name' => $data['name'],
                    'edition_id' => $data['edition_id'],
                    'publication_date' => $data['publication_date'],
                    'index_id' => $data['index_id'],
                    'student_id' => $data['student_id'],
                ];

                if (ScientificPublications::create($scientificPublicationData)) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['success_message'] = 'Научная публикация успешно добавлена!';
                    app()->route->redirect('/scientificPublications');
                    return '';
                } else {
                    $errors[] = 'Ошибка при сохранении научной публикации в базу данных.';
                }
            }
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = implode('<br>', $errors);
            app()->route->redirect('/scientificPublications');
            return '';
        }

        $editions = Editions::all();
        $indexes = Indexes::all();
        $students = Student::all();

        return (new View())->render('site.scientific_publications',
            [
                'editions' => $editions,
                'indexes' => $indexes,
                'students' => $students,
                'scientific_publications' => ScientificPublications::with(['edition', 'index', 'student'])->get(),
                'message' => $message,
                'error' => $errors, // Pass errors to the view for display
            ]);
    }
}
