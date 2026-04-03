<?php

namespace PopItMvc\Validator\Request;

use PopItMvc\Validator\Validator;

abstract class AppValidator
{
    protected array $rules = [];
    protected array $messages = [];
    protected Validator $validator;

    public function __construct(array $data)
    {
        $this->validator = new Validator($data, $this->rules, $this->messages);
    }

    public function fails(): bool
    {
        return $this->validator->fails();
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }

    public function getErrorsAsString(): string
    {
        return implode('<br>', array_reduce($this->errors(), 'array_merge', []));
    }

    public function validateAndRedirect(string $redirectUrl): void
    {
        if ($this->fails()) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = $this->getErrorsAsString();
            app()->route->redirect($redirectUrl);
            exit(); // Stop execution after redirect
        }
    }
}
