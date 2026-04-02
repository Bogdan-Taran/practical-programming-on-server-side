<?php

namespace Controller;


use Model\Dissertations;
use Model\Editions;
use Model\Indexes;
use Model\ScientificPublications;
use Model\Student;
use Src\Validator\Validator;
use Src\View;
use Src\Request;

class StatisticController
{
    public function createStatistic(Request $request)
    {
        $dissertation_count = null;

        if ($request->method === 'POST') {
            $data = $request->all();
            $validator = new Validator($data, [
                'start_date' => ['required'],
                'end_date' => ['required']
            ], [
                'required' => 'Поле :field не может быть пустым.',
            ]);

            if ($validator->fails()) {
                $_SESSION['error_message'] = implode('<br>', array_reduce($validator->errors(), 'array_merge', []));
                app()->route->redirect('/createStatistic');
                return '';
            }

            $startDate = $data['start_date'];
            $endDate = $data['end_date'];

            // Count scientific publications within the date range
            $dissertation_count = Dissertations::whereBetween('approval_date', [$startDate, $endDate])->count();

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['success_message'] = 'Отчёт успешно сформирован.';
            $_SESSION['dissertation_count'] = $dissertation_count;
            $_SESSION['start_date'] = $startDate;
            $_SESSION['end_date'] = $endDate;
            app()->route->redirect('/createStatistic');
            return '';
        }
        $errors = [];
        if (isset($_SESSION['error_message'])) {
            $errors = explode('<br>', $_SESSION['error_message']);
            unset($_SESSION['error_message']);
        }

        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);


        return (new View())->render('site.create_statistic',
            [
                'message' => $message,
                'errors' => $errors,
                'dissertation_count' => $dissertation_count,
            ]);

    }
}
