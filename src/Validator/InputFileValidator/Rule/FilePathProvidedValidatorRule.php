<?php

namespace App\Validator\InputFileValidator\Rule;

use App\Validator\Error\InputFileNotProvidedValidatorError;

class FilePathProvidedValidatorRule implements InputValidatorRuleInterface
{
    #[\Override]
    public function validate(?string $path = null): array
    {
        if (!$path) {
            return [new InputFileNotProvidedValidatorError()];
        }

        return [];
    }
}
