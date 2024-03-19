<?php

namespace App\Reader;

use App\Dto\CountryDto;

class CountryReader implements CountryReaderInterface
{
    /**
     * @param list<string> $euCountryList The list of alpha2 codes.
     */
    public function __construct(private readonly array $euCountryList)
    {
    }

    #[\Override]
    public function isEUCountry(CountryDto $countryDto): bool
    {
        return in_array($countryDto->getAlpha2(), $this->euCountryList);
    }
}
