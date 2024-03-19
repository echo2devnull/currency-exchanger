<?php

namespace App\Renderer;

class FeeRenderer implements FeeRendererInterface
{
    #[\Override]
    public function renderFees(array $feeDtos): void
    {
        foreach ($feeDtos as $feeDto) {
            echo $feeDto->getAmount() . PHP_EOL;
        }
    }
}
