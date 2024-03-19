<?php

namespace App\Validator\InputFileValidator\Rule;

use App\Validator\Error\FileNotFoundValidationError;

class FileExistsValidatorRule implements InputValidatorRuleInterface
{
    #[\Override]
    public function validate(?string $path = null): array
    {
        if (!$path) {
            return [];
        }

        if (!is_file($path) || !is_readable($path)) {
            return [new FileNotFoundValidationError()];
        }

        return [];
    }
}
