<?php

namespace App\Validator\Error;

class InputFileNotProvidedValidatorError implements ValidatorErrorInterface
{
    private const string MESSAGE = 'File path is not provided.';

    #[\Override]
    public function getMessage(): string
    {
        return static::MESSAGE;
    }
}
