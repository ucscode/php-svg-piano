<?php

namespace Ucscode\PhpSvgPiano\Pattern;

use Ucscode\PhpSvgPiano\Traits\StyleTrait;
use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;

class Pattern
{
    use StyleTrait;
    use CoordinateTrait;
    use DimensionTrait;

    // protected ?string $pressedStroke = null;
    // protected ?string $pressedFill = null;
    // protected int $strokeWidth = 1;

    public function __construct(int $width = 0, int $height = 0, ?string $stroke = null, ?string $fill = null, int $strokeWidth = 1)
    {
        $this
            ->setWidth($width)
            ->setHeight($height)
            ->setStroke($stroke)
            ->setFill($fill)
            ->setStrokeWidth($strokeWidth)
        ;
    }
}
