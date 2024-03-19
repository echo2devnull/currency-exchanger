<?php

namespace App\Reader;

use App\Mapper\FileRowMapperInterface;

class FileReader implements FileReaderInterface
{
    public function __construct(private readonly FileRowMapperInterface $fileRowMapper)
    {
    }

    #[\Override]
    public function getRows(string $filePath): array
    {
        $dtos = [];
        foreach (array_filter(explode(PHP_EOL, file_get_contents($filePath))) as $row) {
            $dtos[] = $this->fileRowMapper->mapFileRowDataToFileRowDto(json_decode($row, true));
        }

        return $dtos;
    }
}
