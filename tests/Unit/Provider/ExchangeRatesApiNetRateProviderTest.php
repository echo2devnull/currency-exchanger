<?php

namespace App\Tests\Unit\Provider;

use App\Dto\FileRowDto;
use App\Dto\RateDto;
use App\Exception\ExternalServiceException;
use App\Provider\ExchangeRatesApiNetRateProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ExchangeRatesApiNetRateProviderTest extends TestCase
{
    public function testGetRateReturnsRateWhenExternalServiceReturnsCorrectData(): void
    {
        $apiKey = 'test-api-key';
        $currency = 'USD';
        $expectedRate = 1.23396;

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $responseContent = ['rates' => [$currency => $expectedRate]];

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('toArray')->willReturn($responseContent);

        $httpClientMock->method('request')->willReturn($responseMock);

        $provider = new ExchangeRatesApiNetRateProvider($httpClientMock, $apiKey);
        $rowDto = new FileRowDto('', 0, $currency);
        $result = $provider->getRate($rowDto);

        $this->assertInstanceOf(RateDto::class, $result);
        $this->assertEquals($currency, $result->getCurrency());
        $this->assertEquals($expectedRate, $result->getAmount());
    }

    public function testGetRateThrowsExceptionWhenExternalServiceReturnsNon200StatusCode(): void
    {
        $apiKey = 'test-api-key';
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(429);
        $httpClientMock->method('request')->willReturn($responseMock);

        $provider = new ExchangeRatesApiNetRateProvider($httpClientMock, $apiKey);
        $rowDto = new FileRowDto('', 0, 'USD');

        $this->expectException(ExternalServiceException::class);
        $provider->getRate($rowDto);
    }

    public function testGetRateUsesInternalCacheAfterFirstRequest(): void
    {
        $apiKey = 'test-api-key';
        $currency1 = 'USD';
        $currency2 = 'GBP';
        $expectedRate1 = 1.23396;
        $expectedRate2 = 0.882047;

        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $responseContent1 = ['rates' => [$currency1 => $expectedRate1, $currency2 => $expectedRate2]];
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('toArray')->willReturn($responseContent1);

        $httpClientMock->expects($this->once())->method('request')->willReturn($responseMock);

        $provider = new ExchangeRatesApiNetRateProvider($httpClientMock, $apiKey);

        $rowDto1 = new FileRowDto('', 0, $currency1);
        $result1 = $provider->getRate($rowDto1);

        $rowDto2 = new FileRowDto('', 0, $currency2);
        $result2 = $provider->getRate($rowDto2);

        $this->assertEquals($expectedRate1, $result1->getAmount());
        $this->assertEquals($expectedRate2, $result2->getAmount());
    }
}
