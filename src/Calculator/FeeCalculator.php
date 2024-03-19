<?php

namespace App\Calculator;

use App\Dto\FeeDto;
use App\Provider\BinProviderInterface;
use App\Reader\CountryReaderInterface;
use App\Provider\RateProviderInterface;

class FeeCalculator implements FeeCalculatorInterface
{
    private const float RATE_EU = 0.01;
    private const float RATE_GENERAL = 0.02;

    private const string CURRENCY_EUR = 'EUR';

    public function __construct(
        private readonly BinProviderInterface $binProvider,
        private readonly RateProviderInterface $rateProvider,
        private readonly CountryReaderInterface $countryReader,
    ) {
    }

    public function calculate(array $rowDtos): array
    {
        $feeDtos = [];
        foreach ($rowDtos as $rowDto) {
            $binDto = $this->binProvider->getBin($rowDto);
            $rateDto = $this->rateProvider->getRate($rowDto);
            $rate = $rateDto->getAmount();

            $transactionAmount = $rowDto->getCurrency() === self::CURRENCY_EUR || $rate === 0.0
                ? $rowDto->getAmount()
                : $rowDto->getAmount() / $rate;

            $feeRate = $this->countryReader->isEUCountry($binDto->getCountryDto())
                ? static::RATE_EU
                : static::RATE_GENERAL;
            $feeAmount = $transactionAmount * $feeRate;

            $feeDtos[] = new FeeDto($feeAmount);
        }

        return $feeDtos;
    }
}
