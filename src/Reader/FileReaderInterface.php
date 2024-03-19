<?php

namespace App\Reader;

interface FileReaderInterface
{
    /**
     * @param string $filePath
     *
     * @return list<\App\Dto\FileRowDto>
     */
    public function getRows(string $filePath): array;
}
