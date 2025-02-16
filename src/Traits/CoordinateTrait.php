<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait CoordinateTrait
{
    protected int $x = 0;
    protected int $y = 0;

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $xAxis): static
    {
        $this->x = $xAxis;

        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $yAxis): static
    {
        $this->y = $yAxis;

        return $this;
    }
}
