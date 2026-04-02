<?php

namespace Controller;

use Validators\Request\DeleteScientificPublicationValidator;
use Validators\Request\ScientificPublicationValidator;
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
        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new ScientificPublicationValidator($data);
            $validator->validateAndRedirect('/scientificPublications');

            $scientificPublicationData = [
                'name' => $data['name'],
                'edition_id' => $data['edition_id'],
                'publication_date' => $data['publication_date'],
                'index_id' => $data['index_id'],
                'student_id' => $data['student_id'],
            ];

            if (ScientificPublications::create($scientificPublicationData)) {
                $_SESSION['success_message'] = 'Научная публикация успешно добавлена!';
                app()->route->redirect('/scientificPublications');
                return '';
            } else {
                $_SESSION['error_message'] = 'Ошибка при сохранении научной публикации в базу данных.';
                app()->route->redirect('/scientificPublications');
                return '';
            }

        }
        $errors = [];
        if (isset($_SESSION['error_message'])) {
            $errors = explode('<br>', $_SESSION['error_message']);
            unset($_SESSION['error_message']);
        }
        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);
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

    public function updateScientificPublication(Request $request): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $publication = null;

        if ($request->method === 'POST') {
            $data = $request->all();
            $publicationId = $data['scientific_publication_id'] ?? null;

            if (!$publicationId) {
                $_SESSION['error_message'] = 'Идентификатор публикации не указан.';
                app()->route->redirect('/scientificPublications');
                return '';
            }

            $publication = ScientificPublications::find($publicationId);

            if (!$publication) {
                $_SESSION['error_message'] = 'Публикация не найдена.';
                app()->route->redirect('/scientificPublications');
                return '';
            }

            $validator = new ScientificPublicationValidator($data);
            $validator->validateAndRedirect('/scientificPublications');

            $publication->name = $data['name'];
            $publication->edition_id = $data['edition_id'];
            $publication->publication_date = $data['publication_date'];
            $publication->index_id = $data['index_id'];
            $publication->student_id = $data['student_id'];

            if ($publication->save()) {
                $_SESSION['success_message'] = 'Научная публикация успешно обновлена!';
                app()->route->redirect('/scientificPublications');
                return '';
            } else {
                $_SESSION['error_message'] = 'Ошибка при обновлении научной публикации в базу данных.';
                app()->route->redirect('/scientificPublications');
                return '';
            }
        }
        $errors = [];
        if (isset($_SESSION['error_message'])) {
            $errors = explode('<br>', $_SESSION['error_message']);
            unset($_SESSION['error_message']);
        }

        $editions = Editions::all();
        $indexes = Indexes::all();
        $students = Student::all();

        return (new View())->render('site.edit_scientific_publication', [
            'publication' => $publication,
            'editions' => $editions,
            'indexes' => $indexes,
            'students' => $students,
            'errors' => $errors,
        ]);
    }

    public function deleteScientificPublication(Request $request): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($request->method === 'POST') {
            $data = $request->all();
            $publicationId = $data['scientific_publication_id'] ?? null;

            $validator = new DeleteScientificPublicationValidator($data);
            $validator->validateAndRedirect('/scientificPublications');


            $publication = ScientificPublications::find($publicationId);

            if (!$publication) {
                $_SESSION['error_message'] = 'Публикация не найдена.';
                app()->route->redirect('/scientificPublications');
                return '';
            }

            if ($publication->delete()) {
                $_SESSION['success_message'] = 'Научная публикация успешно удалена!';
            } else {
                $_SESSION['error_message'] = 'Ошибка при удалении научной публикации.';
            }
        } else {
            $_SESSION['error_message'] = 'Неверный метод запроса для удаления публикации.';
        }

        app()->route->redirect('/scientificPublications');
        return '';
    }
}
