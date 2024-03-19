<?php

namespace App\Validator\Error;

class FileNotFoundValidationError implements ValidatorErrorInterface
{
    private const string MESSAGE = 'Given input file is not found.';

    #[\Override]
    public function getMessage(): string
    {
        return static::MESSAGE;
    }
}
