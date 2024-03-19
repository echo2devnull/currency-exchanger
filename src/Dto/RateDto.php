<?php

namespace App\Dto;

class RateDto
{
    public function __construct(
        private readonly string $currency,
        private readonly float $amount,
    ) {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
