<?php

namespace PopItMvc\Validator\Request;

class DeleteScientificPublicationValidator extends AppValidator
{
    protected array $rules = [
        'scientific_publication_id' => ['required'],
    ];

    protected array $messages = [
        'required' => 'Идентификатор публикации не указан.',
    ];
}
