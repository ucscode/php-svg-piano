<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait AxisMethodsTrait
{
    public function getLeft(): int
    {
        return $this->x;
    }

    public function getRight(): int
    {
        return $this->x + $this->width;
    }

    public function getTop(): int
    {
        return $this->y;
    }

    public function getBottom(): int
    {
        return $this->y + $this->height;
    }
}
