<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait AxisMethodsTrait
{
    public function getLeft(): float
    {
        return $this->x;
    }

    public function getRight(): float
    {
        return $this->x + $this->width;
    }

    public function getTop(): float
    {
        return $this->y;
    }

    public function getBottom(): float
    {
        return $this->y + $this->height;
    }
}
