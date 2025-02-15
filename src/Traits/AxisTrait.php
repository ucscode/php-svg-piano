<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait AxisTrait
{
    protected ?int $xAxis = null;
    protected ?int $yAxis = null;

    public function getXAxis(): ?int
    {
        return $this->xAxis;
    }

    public function setXAxis(?int $xAxis): static
    {
        $this->xAxis = $xAxis;

        return $this;
    }

    public function getYAxis(): ?int
    {
        return $this->yAxis;
    }

    public function setYAxis(?int $yAxis): static
    {
        $this->yAxis = $yAxis;

        return $this;
    }
}
