<?php

namespace App\Dto;

class BinDto
{
    public function __construct(private readonly BankDto $bankDto, private readonly CountryDto $countryDto)
    {
    }

    public function getBankDto(): BankDto
    {
        return $this->bankDto;
    }

    public function getCountryDto(): CountryDto
    {
        return $this->countryDto;
    }
}
