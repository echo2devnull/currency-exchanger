<?php

namespace App\Tests\Unit\Mapper;

use App\Exception\InvalidInputArgumentException;
use App\Mapper\ValidationErrorMapper;
use App\Validator\Error\FileNotFoundValidationError;
use App\Validator\Error\InputFileNotProvidedValidatorError;
use App\Validator\Error\MalformedFileFormatValidationError;
use Codeception\Test\Unit;

class ValidationErrorMapperTest extends Unit
{
    public function testMapValidatorErrorsToInvalidInputArgumentException(): void
    {
        $validationErrors = [
            new FileNotFoundValidationError(),
            new InputFileNotProvidedValidatorError(),
            new MalformedFileFormatValidationError(3),
        ];

        $message = "Given input file is not found.\nFile path is not provided.\nRow 3 is not valid JSON format.\n";
        $expectedException = new InvalidInputArgumentException($message);

        $resultException = (new ValidationErrorMapper())
            ->mapValidatorErrorsToInvalidInputArgumentException($validationErrors);

        $this->assertInstanceOf(InvalidInputArgumentException::class, $resultException);
        $this->assertEquals($expectedException, $resultException);
    }
}
