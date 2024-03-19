<?php

namespace App\Tests\Unit\Provider;

use App\Dto\BinDto;
use App\Dto\CountryDto;
use App\Dto\FileRowDto;
use App\Exception\ExternalServiceException;
use App\Provider\BinListNetBinProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class BinListNetBinProviderTest extends TestCase
{
    public function testGetBinReturnsBinDtoWhenExternalServiceReturnsCorrectData(): void
    {
        $responseContent = [
            'bank' => ['name' => 'Sample Bank'],
            'country' => ['name' => 'Sample Country', 'alpha2' => 'SC']
        ];
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('toArray')->willReturn($responseContent);

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock->method('request')->willReturn($responseMock);

        $fileRowDto = new FileRowDto('123456', 100.50, 'EUR');
        $result = (new BinListNetBinProvider($httpClientMock))->getBin($fileRowDto);

        $this->assertInstanceOf(BinDto::class, $result);
        $this->assertEquals(new BinDto(new CountryDto('Sample Country', 'SC')), $result);
    }

    public function testGetBinThrowsExceptionWhenExternalServiceReturnsNon200StatusCode(): void
    {
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(429);

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock->method('request')->willReturn($responseMock);

        $fileRowDto = new FileRowDto('123456', 100.50, 'EUR');
        $this->expectException(ExternalServiceException::class);
        (new BinListNetBinProvider($httpClientMock))->getBin($fileRowDto);
    }

    public function testGetBinUsesInternalCacheForSubsequentCallsWithSameBin(): void
    {
        $rowDto = new FileRowDto('123456', 100.50, 'EUR');
        $responseContent = [
            'bank' => ['name' => 'Sample Bank'],
            'country' => ['name' => 'Sample Country', 'alpha2' => 'SC']
        ];

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('toArray')->willReturn($responseContent);

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock->expects($this->once())->method('request')->willReturn($responseMock);

        $provider = new BinListNetBinProvider($httpClientMock);
        $provider->getBin($rowDto);
        $provider->getBin($rowDto);
    }
}
