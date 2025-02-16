<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait DimensionTrait
{
    protected float $width = 0;
    protected float $height = 0;

    public function getWidth(): float
    {
        return $this->width;
    }

    public function setWidth(float $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): static
    {
        $this->height = $height;

        return $this;
    }
}
