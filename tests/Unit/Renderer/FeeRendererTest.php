<?php

namespace App\Tests\Unit\Renderer;

use App\Dto\FeeDto;
use App\Renderer\FeeRenderer;
use Codeception\Test\Unit;

class FeeRendererTest extends Unit
{
    public function testRenderFeesOutputsAmountForEachFee(): void
    {
        $feeDto1 = new FeeDto(100);
        $feeDto2 = new FeeDto(50);
        $feeDto3 = new FeeDto(200);

        $renderer = new FeeRenderer();
        ob_start();
        $renderer->renderFees([$feeDto1, $feeDto2, $feeDto3]);
        $output = ob_get_clean();

        $this->assertEquals("100\n50\n200\n", $output);
    }
}
