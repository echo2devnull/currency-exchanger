<?php

namespace App\Validator\InputFileValidator;

interface InputFileValidatorInterface
{
    /**
     * @param string|null $filePath
     *
     * @return list<\App\Validator\Error\ValidatorErrorInterface>
     */
    public function validate(?string $filePath = null): array;
}
