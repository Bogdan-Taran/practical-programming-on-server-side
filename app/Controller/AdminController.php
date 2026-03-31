<?php

namespace Controller;


use Model\User;
use Src\View;
use Controller\Site;
use Model\UsersRoles;
use Model\AcademicDegree;
use Model\Student;
use Model\Group;
use Model\Specialization;

class AdminController extends Site
{


    public function addScientificSupervisor(){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? null;
            $password = $_POST['password'] ?? null;
            $firstname = $_POST['firstname'] ?? null;
            $lastname = $_POST['lastname'] ?? null;
            $patronymic = $_POST['patronymic'] ?? null;
            $academic_degree_id = $_POST['academic_degree_id'] ?? null;

            if (empty($login)) {
                $errors[] = 'Логин не может быть пустым';
            }
            if (empty($password)) {
                $errors[] = 'Пароль не может быть пустым';
            }
            if (empty($firstname)) {
                $errors[] = 'Имя не может быть пустым';
            }
            if (empty($lastname)) {
                $errors[] = 'Фамилия не может быть пустой';
            }
            if (empty($patronymic)) {
                $errors[] = 'Отчество не может быть пустым';
            }
            if (empty($academic_degree_id)) {
                $errors[] = 'Укажите ученую степень';
            }

            if (empty($errors)) {
                $user = new User();
                $user->login = $login;
                $user->password_hash = password_hash($password, PASSWORD_DEFAULT);
                $user->firstname = $firstname;
                $user->lastname = $lastname;
                $user->patronymic = $patronymic;
                $user->role_id = User::ROLE_SUPERVISOR; // Scientific Supervisor role
                $user->academic_degree_id = $academic_degree_id;
                $user->save();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['success_message'] = 'Научный руководитель успешно зарегистрирован!';
                $success = true;
                app()->route->redirect('/admin');
                return ''; // Прекращаем выполнение после редиректа
            }
        }

        $academic_degrees = AcademicDegree::all();

        return (new View())->render('site.add_scientific_supervisor', [
            'errors' => $errors,
            'success' => $success,
            'academic_degrees' => $academic_degrees,
        ]);
    }

    public function addStudent(){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Обработка данных формы
            $firstname = $_POST['firstname'] ?? null;
            $lastname = $_POST['lastname'] ?? null;
            $patronymic = $_POST['patronymic'] ?? null;
            $group_id = $_POST['group_id'] ?? null;
            $specialization_id = $_POST['specialization_id'] ?? null;
            $scientific_supervisor_id = $_POST['scientific_supervisor_id'] ?? null;


            if (empty($firstname)) {
                $errors[] = 'Имя не может быть пустым';
            }
            if (empty($lastname)) {
                $errors[] = 'Фамилия не может быть пустой';
            }
            if (empty($patronymic)) {
                $errors[] = 'Отчество не может быть пустым';
            }
            if(empty($group_id)){
                $errors[] = 'Не выбрана группа';
            }
            if(empty($specialization_id)){
                $errors[] = 'Не выбрана специализация';
            }
            if(empty($scientific_supervisor_id)){
                $errors[] = 'Не выбран научный руководитель';
            }

            if (empty($errors)) {
                $student = new Student();
                $student->firstname = $firstname;
                $student->lastname = $lastname;
                $student->patronymic = $patronymic;
                $student->group_id = $group_id;
                $student->specialization_id = $specialization_id;
                $student->scientific_supervisor_id = $scientific_supervisor_id;

                $student->save();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $success = true;
                $_SESSION['success_message'] = 'Студент успешно зарегистрирован';
                app()->route->redirect('/admin');
                return '';
            }
        }

        $groups = Group::all();
        $specializations = Specialization::all();
        $supervisors = User::where('role_id', User::ROLE_SUPERVISOR)->get();

        return (new View())->render('site.add_student', [
            'errors' => $errors,
            'success' => $success,
            'groups' => $groups,
            'specializations' => $specializations,
            'supervisors' => $supervisors,
        ]);
    }
}
