<?php

namespace App\Mapper;

use App\Dto\FileRowDto;

interface FileRowMapperInterface
{
    public function mapFileRowDataToFileRowDto(array $fileRowData): FileRowDto;
}
