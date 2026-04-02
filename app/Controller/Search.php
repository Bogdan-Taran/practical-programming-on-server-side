<?php
namespace Controller;


use Model\Student;
use Src\Request;
use Src\View;

class Search
{


    public function search(Request $request): string
    {
        $searchQuery = $request->get('search-query') ?? ''; // Получаем запрос, по умолчанию пустая строка
        $students = []; // Инициализируем список студентов как пустой массив
        $supervisor = '';

        // Выполняем поиск только если запрос не пуст
        if ($searchQuery !== '') {
            // Предполагается, что у вас есть метод для поиска студентов по фамилии научного руководителя
            $students = Student::searchBySupervisorLastName($searchQuery);
            $supervisor = Student::getSupervisorByQuery($searchQuery);
        }

        // Всегда передаем обе переменные в представление
        return new View('site.search', [
            'students' => $students,
            'searchQuery' => $searchQuery,
            'supervisor' => $supervisor
        ]);
    }


}
