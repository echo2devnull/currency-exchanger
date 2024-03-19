<?php

namespace App\Tests\Unit\Validator\InputFileValidator\Rule;

use App\Validator\Error\FileNotFoundValidationError;
use App\Validator\InputFileValidator\Rule\FileExistsValidatorRule;
use Codeception\Test\Unit;

class FileExistsValidatorRuleTest extends Unit
{
    public function testValidateReturnsNoErrorsWhenFileExists(): void
    {
        $rule = new FileExistsValidatorRule();
        $path = codecept_data_dir('valid_input_file.txt');

        $errors = $rule->validate($path);

        $this->assertEmpty($errors);
    }

    public function testValidateReturnsErrorWhenFileDoesNotExist(): void
    {
        $rule = new FileExistsValidatorRule();
        $path = codecept_data_dir('non_existing_file.txt');

        $errors = $rule->validate($path);

        $this->assertCount(1, $errors);
        $this->assertInstanceOf(FileNotFoundValidationError::class, $errors[0]);
    }
}
