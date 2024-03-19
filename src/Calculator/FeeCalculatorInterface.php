<?php

namespace App\Calculator;

interface FeeCalculatorInterface
{
    /**
     * @param list<\App\Dto\FileRowDto> $rowDtos
     *
     * @return list<\App\Dto\FeeDto>
     */
    public function calculate(array $rowDtos): array;
}
