<?php

namespace App\Dto;

class CountryDto
{
    public function __construct(private readonly string $name, private readonly string $alpha2)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlpha2(): string
    {
        return $this->alpha2;
    }
}
