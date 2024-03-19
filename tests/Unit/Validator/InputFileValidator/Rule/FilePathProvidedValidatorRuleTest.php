<?php

namespace App\Tests\Unit\Validator\InputFileValidator\Rule;

use App\Validator\Error\InputFileNotProvidedValidatorError;
use App\Validator\InputFileValidator\Rule\FilePathProvidedValidatorRule;
use Codeception\Test\Unit;

class FilePathProvidedValidatorRuleTest extends Unit
{
    public function testValidateReturnsNoErrorsWhenFilePathIsProvided(): void
    {
        $rule = new FilePathProvidedValidatorRule();
        $path = 'example/path/to/file.txt';

        $errors = $rule->validate($path);

        $this->assertEmpty($errors);
    }

    public function testValidateReturnsErrorWhenFilePathIsNotProvided(): void
    {
        $rule = new FilePathProvidedValidatorRule();
        $path = null;

        $errors = $rule->validate($path);

        $this->assertCount(1, $errors);
        $this->assertInstanceOf(InputFileNotProvidedValidatorError::class, $errors[0]);
    }
}
