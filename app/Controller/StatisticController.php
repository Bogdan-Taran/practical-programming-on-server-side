<?php

namespace Controller;

use PopItMvc\Validator\Request\StatisticValidator;
use Model\Dissertations;
use Model\Editions;
use Model\Indexes;
use Model\ScientificPublications;
use Model\Student;
use Src\View;
use Src\Request;

class StatisticController
{
    public function createStatistic(Request $request)
    {
        $dissertation_count = null;

        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new StatisticValidator($data);
            $validator->validateAndRedirect('/createStatistic');

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
