<?php

namespace LawFirmManagement\Core;

use Exception;

class ValidationException extends Exception
{
    public function __construct(
        private array $errors
    ) {
        parent::__construct('Validation failed.');
    }

    public function errors(): array
    {
        return $this->errors;
    }
}