<?php

namespace App;

class Application
{
    /**
     * @param \App\Factory $factory
     */
    public function __construct(private readonly Factory $factory)
    {
    }

    public function run(?string $inputFilePath = null): void
    {
        $inputFileValidator = $this->factory->createInputFileValidator();
        $inputFileValidatorErrors = $inputFileValidator->validate($inputFilePath);
        if ($inputFileValidatorErrors) {
            throw $this
                ->factory
                ->createValidationErrorMapper()
                ->mapValidatorErrorsToInvalidInputArgumentException(
                    $inputFileValidatorErrors,
                );
        }

        $fileRowDtos = $this->factory->createFileReader()->getRows($inputFilePath);
        $feeDtos = $this->factory->createFeeCalculator()->calculate($fileRowDtos);

        $this->factory->createFeeRenderer()->renderFees($feeDtos);
    }
}
