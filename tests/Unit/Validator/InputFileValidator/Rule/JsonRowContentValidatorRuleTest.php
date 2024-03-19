<?php

namespace App\Tests\Unit\Validator\InputFileValidator\Rule;

use App\Validator\Error\MalformedFileFormatValidationError;
use App\Validator\InputFileValidator\Rule\JsonRowContentValidatorRule;
use Codeception\Test\Unit;

class JsonRowContentValidatorRuleTest extends Unit
{
    public function testValidateReturnsNoErrorsWhenAllRowsContainValidJson(): void
    {
        $rule = new JsonRowContentValidatorRule();
        $path = codecept_data_dir('valid_input_file.txt');

        $errors = $rule->validate($path);

        $this->assertEmpty($errors);
    }

    public function testValidateReturnsErrorWhenAtLeastOneRowContainsInvalidJson(): void
    {
        $rule = new JsonRowContentValidatorRule();
        $path = codecept_data_dir('invalid_input_file.txt');

        $errors = $rule->validate($path);

        $this->assertNotEmpty($errors);
        foreach ($errors as $error) {
            $this->assertInstanceOf(MalformedFileFormatValidationError::class, $error);
        }
    }
}
