<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait StyleTrait
{
    protected ?string $stroke = null;
    protected ?string $fill = null;
    protected int $strokeWidth = 1;

    public function getFill(): ?string
    {
        return $this->fill;
    }

    public function setFill(?string $fill): static
    {
        $this->fill = $fill;

        return $this;
    }

    public function getStroke(): ?string
    {
        return $this->stroke;
    }

    public function setStroke(?string $stroke): static
    {
        $this->stroke = $stroke;

        return $this;
    }

    public function getStrokeWidth(): ?string
    {
        return $this->strokeWidth;
    }

    public function setStrokeWidth(int $width): static
    {
        $this->strokeWidth = $width;

        return $this;
    }
}
