<?php

namespace Validators\Request;

class AddDissertationValidator extends AppValidator
{
    protected array $rules = [
        'theme' => ['required'],
        'student_id' => ['required'],
        'approval_date' => ['required'],
        'dissertation_status_id' => ['required'],
        'bak_speciality_id' => ['required']
    ];
    protected array $messages = [
        'required' => 'Поле :field не может быть пустым.',
    ];
}