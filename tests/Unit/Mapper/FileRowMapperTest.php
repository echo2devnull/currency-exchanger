<?php

namespace App\Tests\Unit\Mapper;

use App\Dto\FileRowDto;
use App\Mapper\FileRowMapper;
use Codeception\Test\Unit;

class FileRowMapperTest extends Unit
{
    public function testMapFileRowDataToFileRowDto(): void
    {
        $data = [
            'bin' => '123456',
            'amount' => 100.50,
            'currency' => 'EUR',
        ];

        $expectedDto = new FileRowDto(
            $data['bin'],
            $data['amount'],
            $data['currency']
        );

        $resultDto = (new FileRowMapper())->mapFileRowDataToFileRowDto($data);

        $this->assertInstanceOf(FileRowDto::class, $resultDto);
        $this->assertEquals($expectedDto, $resultDto);
    }
}
