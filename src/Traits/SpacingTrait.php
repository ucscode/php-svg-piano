<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait SpacingTrait
{
    protected float $spaceLeft = 0;
    protected float $spaceRight = 0;
    protected float $spaceBottom = 0;
    protected float $spaceTop = 0;

    public function setSpaceLeft(float $spaceLeft): static
    {
        $this->spaceLeft = $spaceLeft;

        return $this;
    }

    public function getSpaceLeft(): float
    {
        return $this->spaceLeft;
    }

    public function setSpaceRight(float $spaceRight): static
    {
        $this->spaceRight = $spaceRight;

        return $this;
    }

    public function getSpaceRight(): float
    {
        return $this->spaceRight;
    }

    public function setSpaceBottom(float $spaceBottom): static
    {
        $this->spaceBottom = $spaceBottom;

        return $this;
    }

    public function getSpaceBottom(): float
    {
        return $this->spaceBottom;
    }

    public function setSpaceTop(float $spaceTop): static
    {
        $this->spaceTop = $spaceTop;

        return $this;
    }

    public function getSpaceTop(): float
    {
        return $this->spaceTop;
    }

    public function getSpaceX(): float
    {
        return $this->spaceLeft + $this->spaceRight;
    }

    public function getSpaceY(): float
    {
        return $this->spaceTop + $this->spaceBottom;
    }

    public function getSpaceXY(): float
    {
        return $this->getSpaceX() + $this->getSpaceY();
    }
}
