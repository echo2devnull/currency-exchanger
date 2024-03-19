<?php

namespace App\Dto;

class FeeDto
{
    public function __construct(private readonly float $amount)
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
