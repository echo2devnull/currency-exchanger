<?php

namespace App\Tests\Unit\Validator\InputFileValidator;

use App\Validator\Error\FileNotFoundValidationError;
use App\Validator\InputFileValidator\InputFileValidator;
use App\Validator\InputFileValidator\Rule\InputValidatorRuleInterface;
use Codeception\Test\Unit;

class InputFileValidatorTest extends Unit
{
    public function testValidateReturnsNoErrorsWhenAllRulesPass(): void
    {
        $mockRule1 = $this->createMock(InputValidatorRuleInterface::class);
        $mockRule1->method('validate')->willReturn([]);

        $mockRule2 = $this->createMock(InputValidatorRuleInterface::class);
        $mockRule2->method('validate')->willReturn([]);

        $validator = new InputFileValidator([$mockRule1, $mockRule2]);

        $errors = $validator->validate('foo/bar.txt');

        $this->assertEmpty($errors);
    }

    public function testValidateReturnsErrorsWhenAtLeastOneRuleFails(): void
    {
        $mockRule1 = $this->createMock(InputValidatorRuleInterface::class);
        $mockRule1->method('validate')->willReturn([]);

        $mockRule2 = $this->createMock(InputValidatorRuleInterface::class);
        $mockRule2->method('validate')->willReturn([new FileNotFoundValidationError()]);

        $validator = new InputFileValidator([$mockRule1, $mockRule2]);

        $errors = $validator->validate('example/path/to/file.txt');

        $this->assertNotEmpty($errors);
        $this->assertCount(1, $errors);
    }
}
