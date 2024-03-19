<?php

namespace App\Renderer;

interface FeeRendererInterface
{
    /**
     * @param list<\App\Dto\FeeDto> $feeDtos
     *
     * @return void
     */
    public function renderFees(array $feeDtos): void;
}
