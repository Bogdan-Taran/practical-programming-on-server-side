<?php

namespace app\Controller;


use app\model\Role;
use app\model\AcademicDegree;
use app\model\Student;
use app\model\Group;
use app\model\Specialization;
use app\Controller;
use Model\User;

class AdminController extends Controller
{
    public function addUser()
    {
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Обработка данных формы
            $role_id = $_POST['role_id'] ?? null;
            $login = $_POST['login'] ?? null;
            $password = $_POST['password'] ?? null;
            $firstname = $_POST['firstname'] ?? null;
            $lastname = $_POST['lastname'] ?? null;
            $patronymic = $_POST['patronymic'] ?? null;

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
            if (empty($role_id)) {
                $errors[] = 'Роль не выбрана';
            }

            if (empty($errors)) {
                if ($role_id == 1) { // Научный руководитель
                    $academic_degree_id = $_POST['academic_degree_id'] ?? null;
                    if (empty($academic_degree_id)) {
                        $errors[] = 'Укажите ученую степень';
                    } else {
                        $user = new User();
                        $user->login = $login;
                        $user->password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $user->firstname = $firstname;
                        $user->lastname = $lastname;
                        $user->patronymic = $patronymic;
                        $user->role_id = $role_id;
                        $user->academic_degree_id = $academic_degree_id;
                        $user->save();
                        $success = true;
                    }
                } elseif ($role_id == 2) { // Аспирант
                    $group_id = $_POST['group_id'] ?? null;
                    $specialization_id = $_POST['specialization_id'] ?? null;
                    $scientific_supervisor_id = $_POST['scientific_supervisor_id'] ?? null;

                    if (empty($group_id)) {
                        $errors[] = 'Укажите группу';
                    }
                    if (empty($specialization_id)) {
                        $errors[] = 'Укажите специализацию';
                    }
                    if (empty($scientific_supervisor_id)) {
                        $errors[] = 'Укажите научного руководителя';
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
                        $success = true;
                    }
                }
            }
        }

        $roles = Role::getAll();
        $academic_degrees = AcademicDegree::getAll();
        $groups = Group::getAll();
        $specializations = Specialization::getAll();
        $supervisors = User::where('role_id', 1);

        $this->view->render('site/add_user', [
            'errors' => $errors,
            'success' => $success,
            'roles' => $roles,
            'academic_degrees' => $academic_degrees,
            'groups' => $groups,
            'specializations' => $specializations,
            'supervisors' => $supervisors,
        ]);
    }
}
