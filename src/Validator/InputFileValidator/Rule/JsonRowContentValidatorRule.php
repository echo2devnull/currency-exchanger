<?php

namespace App\Validator\InputFileValidator\Rule;

use App\Validator\Error\MalformedFileFormatValidationError;

class JsonRowContentValidatorRule implements InputValidatorRuleInterface
{
    #[\Override]
    public function validate(?string $path = null): array
    {
        $errors = [];
        if (!$path) {
            return $errors;
        }

        $content = file_get_contents($path);
        foreach (array_filter(explode(PHP_EOL, $content)) as $i => $row) {
            $json = json_decode($row);
            if ($json === null) {
                $errors[] = new MalformedFileFormatValidationError($i);
            }
        }

        return $errors;
    }
}
