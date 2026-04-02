<?php

namespace Controller;


use Model\Dissertations;
use Model\Editions;
use Model\Indexes;
use Model\ScientificPublications;
use Model\Student;
use Src\View;
use Src\Request;

class StatisticController
{
    public function createStatistic(Request $request){
        $errors = [];
        $message = '';
        $dissertation_count = null;

        if ($request->method === 'POST') {
            $data = $request->all();

            // Validation
            if (empty($data['start_date'])) {
                $errors[] = 'Дата начала не может быть пустой.';
            }
            if (empty($data['end_date'])) {
                $errors[] = 'Дата конца не может быть пустой.';
            }

            if (empty($errors)) {
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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = implode('<br>', $errors);
            app()->route->redirect('/createStatistic'); // Redirect back to the statistic creation page on error
            return '';
        }


        return (new View())->render('site.create_statistic',
            [
                'message' => $message,
                'dissertation_count' => $dissertation_count,
            ]);

    }
}
