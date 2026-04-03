<?php

namespace Controller;

use PopItMvc\Validator\Request\AddScientificSupervisorValidator;
use PopItMvc\Validator\Request\AddStudentValidator;
use Model\User;
use Src\View;
use Model\AcademicDegree;
use Model\Student;
use Model\Group;
use Model\Specialization;
class AdminController extends Site
{

    public function addScientificSupervisor()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Validation
            $requestData = $_POST;

            $validator = new AddScientificSupervisorValidator($requestData);
            $validator->validateAndRedirect('/addScientificSupervisor');

            $user = new User();
            $user->login = $requestData['login'];
            $user->password_hash = password_hash($requestData['password'], PASSWORD_DEFAULT);
            $user->firstname = $requestData['firstname'];
            $user->lastname = $requestData['lastname'];
            $user->patronymic = $requestData['patronymic'];
            $user->role_id = User::ROLE_SUPERVISOR; // Scientific Supervisor role
            $user->academic_degree_id = $requestData['academic_degree_id'];

            if ($user->save()) {
                $_SESSION['success_message'] = 'Научный руководитель успешно добавлен!';
            } else {
                $_SESSION['error_message'] = 'Ошибка при добавлении научного руководителя в базу данных.';
            }
            app()->route->redirect('/admin');
            return '';
        }

        $academic_degrees = AcademicDegree::all();

        $errors = [];
        if (isset($_SESSION['error_message'])) {
            $errors = explode('<br>', $_SESSION['error_message']);
            unset($_SESSION['error_message']);
        }

        $message = $_SESSION['success_message'] ?? null;

        unset($_SESSION['success_message']);
        return (new View())->render('site.add_scientific_supervisor', [
            'errors' => $errors,
            'academic_degrees' => $academic_degrees,
            'message' => $message,
        ]);
    }

    public function addStudent(){
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestData = $_POST;
            $validator = new AddStudentValidator($requestData);
            $validator->validateAndRedirect('/addStudent');

            $student = new Student();
            $student->firstname = $requestData['firstname'];
            $student->lastname = $requestData['lastname'];
            $student->patronymic = $requestData['patronymic'];
            $student->group_id = $requestData['group_id'];
            $student->specialization_id = $requestData['specialization_id'];
            $student->scientific_supervisor_id = $requestData['scientific_supervisor_id'];

            if ($student->save()) {
                $_SESSION['success_message'] = 'Студент успешно добавлен!';
            } else {
                $_SESSION['error_message'] = 'Ошибка при добавлении студента в базу данных.';
            }
            app()->route->redirect('/admin');
            return '';
        }

        $groups = Group::all();
        $specializations = Specialization::all();
        $supervisors = User::where('role_id', User::ROLE_SUPERVISOR)->get();

        $errors = [];
        if (isset($_SESSION['error_message'])) {
            $errors = explode('<br>', $_SESSION['error_message']);
            unset($_SESSION['error_message']);
        }

        $message = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);

        return (new View())->render('site.add_student', [
            'errors' => $errors,
            'groups' => $groups,
            'specializations' => $specializations,
            'message' => $message,
            'supervisors' => $supervisors,
        ]);
    }
}
