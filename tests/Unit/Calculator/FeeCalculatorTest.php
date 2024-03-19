<?php

namespace App\Tests\Unit\Calculator;

use App\Calculator\FeeCalculator;
use App\Dto\BinDto;
use App\Dto\CountryDto;
use App\Dto\FileRowDto;
use App\Dto\RateDto;
use App\Reader\CountryReaderInterface;
use App\Provider\BinProviderInterface;
use App\Provider\RateProviderInterface;
use Codeception\Test\Unit;

class FeeCalculatorTest extends Unit
{
    public function testCalculateFeeForEUCountryWithCurrencyEUR(): void
    {
        $rowDto = new FileRowDto(12345, 100.00, 'EUR');

        $countryDto = new CountryDto('Germany', 'DE');
        $binDto = new BinDto($countryDto);

        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getBin')->willReturn($binDto);

        $rateProviderMock = $this->createMock(RateProviderInterface::class);
        $rateProviderMock->method('getRate')->willReturn(new RateDto('EUR', 1.0));

        $countryReaderMock = $this->createMock(CountryReaderInterface::class);
        $countryReaderMock->method('isEUCountry')->willReturn(true);

        $calculator = new FeeCalculator($binProviderMock, $rateProviderMock, $countryReaderMock);

        $fees = $calculator->calculate([$rowDto]);

        $this->assertCount(1, $fees);
        $this->assertEquals(1, $fees[0]->getAmount());
    }

    public function testCalculateFeeForNonEUCountryWithNonEURCurrency(): void
    {
        $rowDto = new FileRowDto(12345, 50.00, 'USD');

        $countryDto = new CountryDto('USA', 'US');
        $binDto = new BinDto($countryDto);

        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getBin')->willReturn($binDto);

        $rateProviderMock = $this->createMock(RateProviderInterface::class);
        $rateProviderMock->method('getRate')->willReturn(new RateDto('USD', 1.0864447));

        $countryReaderMock = $this->createMock(CountryReaderInterface::class);
        $countryReaderMock->method('isEUCountry')->willReturn(false);

        $calculator = new FeeCalculator($binProviderMock, $rateProviderMock, $countryReaderMock);

        $fees = $calculator->calculate([$rowDto]);

        $this->assertCount(1, $fees);
        $this->assertEquals(0.93, $fees[0]->getAmount());
    }

    public function testCalculateFeeForEUCountryWithNonEURCurrency(): void
    {
        $rowDto = new FileRowDto(12345, 2000.00, 'GBR');

        $countryDto = new CountryDto('Poland', 'PL');
        $binDto = new BinDto($countryDto);

        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getBin')->willReturn($binDto);

        $rateProviderMock = $this->createMock(RateProviderInterface::class);
        $rateProviderMock->method('getRate')->willReturn(new RateDto('GBR', 0.8541015));

        $countryReaderMock = $this->createMock(CountryReaderInterface::class);
        $countryReaderMock->method('isEUCountry')->willReturn(true);


        $calculator = new FeeCalculator($binProviderMock, $rateProviderMock, $countryReaderMock);

        $fees = $calculator->calculate([$rowDto]);

        $this->assertCount(1, $fees);
        $this->assertEquals(23.42, $fees[0]->getAmount());
    }

    public function testCalculateFeeForNonEUCountryWithEURCurrency(): void
    {
        $rowDto = new FileRowDto(12345, 1100.00, 'EUR');

        $countryDto = new CountryDto('Brazil', 'BR');
        $binDto = new BinDto($countryDto);

        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getBin')->willReturn($binDto);

        $rateProviderMock = $this->createMock(RateProviderInterface::class);
        $rateProviderMock->method('getRate')->willReturn(new RateDto('EUR', 1.0));

        $countryReaderMock = $this->createMock(CountryReaderInterface::class);
        $countryReaderMock->method('isEUCountry')->willReturn(false);

        $calculator = new FeeCalculator($binProviderMock, $rateProviderMock, $countryReaderMock);

        $fees = $calculator->calculate([$rowDto]);

        $this->assertCount(1, $fees);
        $this->assertEquals(22.0, $fees[0]->getAmount());
    }
}
