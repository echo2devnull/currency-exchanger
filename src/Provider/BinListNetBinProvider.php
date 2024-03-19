<?php

namespace App\Provider;

use App\Dto\BankDto;
use App\Dto\BinDto;
use App\Dto\CountryDto;
use App\Dto\FileRowDto;
use App\Exception\ExternalServiceException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BinListNetBinProvider implements BinProviderInterface
{
    private const string BIN_SERVICE_URL_TEMPLATE = 'https://lookup.binlist.net/%d';

    private const string HTTP_METHOD_GET = 'GET';
    private const int HTTP_RESPONSE_OK = 200;

    /**
     * @var array<int, \App\Dto\BinDto>
     */
    private array $cache = [];

    public function __construct(private readonly HttpClientInterface $httpClient)
    {
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
    public function getBin(FileRowDto $rowDto): BinDto
    {
        $bin = $rowDto->getBin();
        if (!isset($this->cache[$bin])) {
            $response = $this->httpClient->request(
                static::HTTP_METHOD_GET,
                sprintf(static::BIN_SERVICE_URL_TEMPLATE, $rowDto->getBin()),
            );

            if ($response->getStatusCode() !== static::HTTP_RESPONSE_OK) {
                throw new ExternalServiceException(
                    sprintf(
                        'Failed to fetch bin data: server respond with %d status code.',
                        $response->getStatusCode(),
                    )
                );
            }

            $this->cache[$bin] = $this->mapBinDataToBinDto($response->toArray());
        }

        return $this->cache[$bin];
    }

    protected function mapBinDataToBinDto(array $binData): BinDto
    {
        var_dump($binData);
        $bankDto = new BankDto($binData['bank']['name']);
        $countryDto = new CountryDto($binData['country']['name'], $binData['country']['alpha2']);

        return new BinDto($bankDto, $countryDto);
    }
}
