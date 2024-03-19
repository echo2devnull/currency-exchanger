<?php

namespace App\Provider;

use App\Dto\FileRowDto;
use App\Dto\RateDto;
use App\Exception\ExternalServiceException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRatesApiNetRateProvider implements RateProviderInterface
{
    private const string RATE_SERVICE_URL = 'https://api.exchangeratesapi.net/v1/exchange-rates/latest';

    private const string HTTP_METHOD_GET = 'GET';
    private const int HTTP_RESPONSE_OK = 200;

    private const string CURRENCY_CODE_EUR = 'EUR';

    /**
     * @var array<string, float>
     */
    private array $cache = [];

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiKey,
    ) {
        $this->cache['EUR'] = 1;
    }

    /**
     * @throws \App\Exception\ExternalServiceException
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    #[\Override]
    public function getRate(FileRowDto $rowDto): RateDto
    {
        $currency = $rowDto->getCurrency();
        if (!isset($this->cache[$currency])) {
            $response = $this->httpClient->request(
                static::HTTP_METHOD_GET,
                static::RATE_SERVICE_URL,
                [
                    'query' => [
                        'access_key' => $this->apiKey,
                        'base' => static::CURRENCY_CODE_EUR,
                    ],
                ],
            );
            if ($response->getStatusCode() !== static::HTTP_RESPONSE_OK) {
                throw new ExternalServiceException('Failed to fetch rate data: ' . $response->getContent(false));
            }
            $this->cacheRates($response->toArray());
        }

        return $this->mapRateDataToRateDto($currency, $this->cache[$currency]);
    }

    protected function cacheRates(array $rateData): void
    {
        foreach ($rateData['rates'] as $currency => $rate) {
            $this->cache[$currency] = $rate;
        }
    }

    protected function mapRateDataToRateDto(string $currency, float $amount): RateDto
    {
        return new RateDto($currency, $amount);
    }
}
