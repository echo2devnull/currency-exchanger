<?php

namespace App\Mapper;

use App\Dto\FileRowDto;

class FileRowMapper implements FileRowMapperInterface
{
    #[\Override]
    public function mapFileRowDataToFileRowDto(array $fileRowData): FileRowDto
    {
        return new FileRowDto(
            $fileRowData['bin'],
            $fileRowData['amount'],
            $fileRowData['currency'],
        );
    }
}
