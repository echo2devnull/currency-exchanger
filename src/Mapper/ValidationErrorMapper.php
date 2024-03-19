<?php

namespace App\Mapper;

use App\Exception\InvalidInputArgumentException;

class ValidationErrorMapper implements ValidationErrorMapperInterface
{
    #[\Override]
    public function mapValidatorErrorsToInvalidInputArgumentException(
        array $validationErrors
    ): InvalidInputArgumentException {
        $message = '';
        foreach ($validationErrors as $validationError) {
            $message .= $validationError->getMessage() . PHP_EOL;
        }

        return new InvalidInputArgumentException($message);
    }
}
