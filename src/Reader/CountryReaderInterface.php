<?php

namespace App\Reader;

use App\Dto\CountryDto;

interface CountryReaderInterface
{
    public function isEUCountry(CountryDto $countryDto): bool;
}
