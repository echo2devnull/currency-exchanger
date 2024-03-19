<?php

namespace App\Provider;

use App\Dto\FileRowDto;
use App\Dto\RateDto;

interface RateProviderInterface
{
    public function getRate(FileRowDto $rowDto): RateDto;
}
