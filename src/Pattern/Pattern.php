<?php

namespace Ucscode\PhpSvgPiano\Pattern;

use Ucscode\PhpSvgPiano\Traits\ColorTrait;
use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;

class Pattern
{
    use ColorTrait;
    use CoordinateTrait;
    use DimensionTrait;

    public function __construct(int $width = 0, int $height = 0, ?string $stroke = null, ?string $fill = null)
    {
        $this
            ->setWidth($width)
            ->setHeight($height)
            ->setStroke($stroke)
            ->setFill($fill)
        ;
    }
}
