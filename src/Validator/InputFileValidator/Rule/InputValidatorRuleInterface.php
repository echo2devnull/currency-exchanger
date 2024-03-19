<?php

namespace App\Validator\InputFileValidator\Rule;

interface InputValidatorRuleInterface
{
    /**
     * @param string|null $filePath
     *
     * @return list<\App\Validator\Error\ValidatorErrorInterface>
     */
    public function validate(?string $filePath = null): array;
}
