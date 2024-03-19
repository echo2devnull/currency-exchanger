<?php

namespace App\Tests\Unit\Reader;

use App\Dto\CountryDto;
use App\Reader\CountryReader;
use Codeception\Test\Unit;

class CountryReaderTest extends Unit
{
    public function testIsEUCountryReturnsTrueWhenEuCountryGiven(): void
    {
        $euCountryList = ['DE', 'FR', 'IT', 'ES'];
        $reader = new CountryReader($euCountryList);

        $euCountryDto = new CountryDto('Germany', 'DE');

        $this->assertTrue($reader->isEUCountry($euCountryDto));
    }

    public function testIsEUCountryReturnsFalseWhenNonEuCountryGiven(): void
    {
        $euCountryList = ['DE', 'FR', 'IT', 'ES'];
        $reader = new CountryReader($euCountryList);

        $nonEuCountryDto = new CountryDto('USA', 'US');

        $this->assertFalse($reader->isEUCountry($nonEuCountryDto));
    }
}
