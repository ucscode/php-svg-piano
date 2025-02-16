<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait ColorTrait
{
    protected ?string $stroke = null;
    protected ?string $fill = null;

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
}
