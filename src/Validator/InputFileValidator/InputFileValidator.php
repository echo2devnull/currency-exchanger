<?php

namespace App\Validator\InputFileValidator;

class InputFileValidator implements InputFileValidatorInterface
{
    /**
     * @param list<\App\Validator\InputFileValidator\Rule\InputValidatorRuleInterface> $rules
     */
    public function __construct(private readonly array $rules)
    {
    }

    #[\Override]
    public function validate(?string $filePath = null): array
    {
        $errors = [];
        foreach ($this->rules as $validationRule) {
            $errors = array_merge($errors, $validationRule->validate($filePath));
        }

        return $errors;
    }
}
