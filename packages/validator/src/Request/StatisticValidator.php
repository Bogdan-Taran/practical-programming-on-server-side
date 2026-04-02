<?php

namespace PopItMvc\Validator\Request;

class StatisticValidator extends AppValidator
{
    protected array $rules = [
        'start_date' => ['required'],
        'end_date' => ['required']
    ];

    protected array $messages = [
        'required' => 'Поле :field не может быть пустым.',
    ];
}
