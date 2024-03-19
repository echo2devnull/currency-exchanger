<?php

namespace App\Provider;

use App\Dto\BinDto;
use App\Dto\FileRowDto;

interface BinProviderInterface
{
    public function getBin(FileRowDto $rowDto): BinDto;
}
