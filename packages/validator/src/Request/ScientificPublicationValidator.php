<?php

namespace PopItMvc\Validator\Request;

class ScientificPublicationValidator extends AppValidator
{
    protected array $rules = [
        'name' => ['required'],
        'edition_id' => ['required'],
        'publication_date' => ['required'],
        'index_id' => ['required'],
        'student_id' => ['required']
    ];

    protected array $messages = [
        'required' => 'Поле :field не может быть пустым.',
    ];
}
