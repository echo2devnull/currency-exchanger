<?php

namespace App\Dto;

class BinDto
{
    public function __construct(private readonly CountryDto $countryDto)
    {
    }

    public function getCountryDto(): CountryDto
    {
        return $this->countryDto;
    }
}
