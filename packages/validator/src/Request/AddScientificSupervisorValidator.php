<?php

namespace PopItMvc\Validator\Request;

class AddScientificSupervisorValidator extends AppValidator
{
    protected array $rules = [
        'login' => ['required', 'unique:users,login'],
        'password' => ['required'],
        'firstname' => ['required'],
        'lastname' => ['required'],
        'patronymic' => ['required'],
        'academic_degree_id' => ['required']
    ];

    protected array $messages = [
        'required' => 'Поле :field не может быть пустым',
        'unique' => 'Пользователь с таким :field уже существует'
    ];
}
