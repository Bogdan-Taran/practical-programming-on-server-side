<?php

namespace PopItMvc\Validator\Request;

class AddStudentValidator extends AppValidator
{
    protected array $rules = [
        'firstname' => ['required'],
        'lastname' => ['required'],
        'patronymic' => ['required'],
        'group_id' => ['required'],
        'specialization_id' => ['required'],
        'scientific_supervisor_id' => ['required']
    ];

    protected array $messages = [
        'required' => 'Поле :field не может быть пустым',
    ];
}
