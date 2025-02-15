<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait DimensionTrait
{
    protected ?int $width = null;
    protected ?int $height = null;

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): static
    {
        $this->height = $height;

        return $this;
    }
}
