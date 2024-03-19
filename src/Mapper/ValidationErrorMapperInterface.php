<?php

namespace App\Mapper;

interface ValidationErrorMapperInterface
{
    /**
     * @param list<\App\Validator\Error\ValidatorErrorInterface> $validationErrors
     *
     * @return \InvalidArgumentException
     */
    public function mapValidatorErrorsToInvalidInputArgumentException(
        array $validationErrors
    ): \InvalidArgumentException;
}
