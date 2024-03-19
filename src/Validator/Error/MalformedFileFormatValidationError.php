<?php

namespace App\Validator\Error;

class MalformedFileFormatValidationError implements ValidatorErrorInterface
{
    private const string MESSAGE_TEMPLATE = 'Row %d is not valid JSON format.';

    public function __construct(private readonly int $rowNumber)
    {
    }


    #[\Override]
    public function getMessage(): string
    {
        return sprintf(static::MESSAGE_TEMPLATE, $this->rowNumber);
    }
}
