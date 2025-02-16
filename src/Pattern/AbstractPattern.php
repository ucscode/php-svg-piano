<?php

namespace Ucscode\PhpSvgPiano\Pattern;

use Ucscode\PhpSvgPiano\Traits\StyleTrait;
use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;

abstract class AbstractPattern
{
    use StyleTrait;
    use CoordinateTrait;
    use DimensionTrait;

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
