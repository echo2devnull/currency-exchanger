<?php

namespace App;

use App\Calculator\FeeCalculator;
use App\Calculator\FeeCalculatorInterface;
use App\Mapper\FileRowMapper;
use App\Mapper\FileRowMapperInterface;
use App\Mapper\ValidationErrorMapper;
use App\Mapper\ValidationErrorMapperInterface;
use App\Provider\BinListNetBinProvider;
use App\Provider\BinProviderInterface;
use App\Reader\CountryReader;
use App\Reader\CountryReaderInterface;
use App\Reader\FileReader;
use App\Reader\FileReaderInterface;
use App\Provider\ExchangeRatesApiNetRateProvider;
use App\Provider\RateProviderInterface;
use App\Renderer\FeeRenderer;
use App\Renderer\FeeRendererInterface;
use App\Validator\InputFileValidator\InputFileValidator;
use App\Validator\InputFileValidator\InputFileValidatorInterface;
use App\Validator\InputFileValidator\Rule\FileExistsValidatorRule;
use App\Validator\InputFileValidator\Rule\FilePathProvidedValidatorRule;
use App\Validator\InputFileValidator\Rule\InputValidatorRuleInterface;
use App\Validator\InputFileValidator\Rule\JsonRowContentValidatorRule;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Factory
{
    public function createInputFileValidator(): InputFileValidatorInterface
    {
        $rules = [
            $this->createFilePathProvidedValidatorRule(),
            $this->createFileExistsValidatorRule(),
            $this->createJsonRowContentValidatorRule(),
        ];

        return new InputFileValidator($rules);
    }

    public function createValidationErrorMapper(): ValidationErrorMapperInterface
    {
        return new ValidationErrorMapper();
    }

    public function createBinProvider(): BinProviderInterface
    {
        return new BinListNetBinProvider(
            $this->createHttpClient(),
        );
    }

    public function createFileReader(): FileReaderInterface
    {
        return new FileReader(
            $this->createFileRowMapper(),
        );
    }

    public function createCountryReader(): CountryReaderInterface
    {
        return new CountryReader(
            $this->getEuCountryCodes(),
        );
    }

    public function createFeeCalculator(): FeeCalculatorInterface
    {
        return new FeeCalculator(
            $this->createBinProvider(),
            $this->createRateProvider(),
            $this->createCountryReader(),
        );
    }

    public function createFeeRenderer(): FeeRendererInterface
    {
        return new FeeRenderer();
    }

    private function createRateProvider(): RateProviderInterface
    {
        return new ExchangeRatesApiNetRateProvider(
            $this->createHttpClient(),
            $this->getExchangeRatesApiNetApiKey(),
        );
    }

    private function createFilePathProvidedValidatorRule(): InputValidatorRuleInterface
    {
        return new FilePathProvidedValidatorRule();
    }

    private function createFileExistsValidatorRule(): InputValidatorRuleInterface
    {
        return new FileExistsValidatorRule();
    }

    private function createJsonRowContentValidatorRule(): InputValidatorRuleInterface
    {
        return new JsonRowContentValidatorRule();
    }

    private function createHttpClient(): HttpClientInterface
    {
        return HttpClient::create();
    }

    private function createFileRowMapper(): FileRowMapperInterface
    {
        return new FileRowMapper();
    }

    /**
     * @return list<string>
     */
    private function getEuCountryCodes(): array
    {
        // TODO: Define it in the configuration file.
        return [
            'AT',
            'BE',
            'BG',
            'CY',
            'CZ',
            'DE',
            'DK',
            'EE',
            'ES',
            'FI',
            'FR',
            'GR',
            'HR',
            'HU',
            'IE',
            'IT',
            'LT',
            'LU',
            'LV',
            'MT',
            'NL',
            'PO',
            'PT',
            'RO',
            'SE',
            'SI',
            'SK',
        ];
    }

    private function getExchangeRatesApiNetApiKey(): string
    {
        return getenv('EXCHANGE_RATES_API_NET_API_KEY');
    }
}
