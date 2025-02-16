<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait CoordinateTrait
{
    protected float $x = 0;
    protected float $y = 0;

    public function getX(): float
    {
        return $this->x;
    }

    public function setX(float $x): static
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function setY(float $y): static
    {
        $this->y = $y;

        return $this;
    }
}
