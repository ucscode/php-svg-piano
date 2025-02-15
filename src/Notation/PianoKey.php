<?php

namespace Ucscode\PhpSvgPiano\Notation;

class PianoKey
{
    public const TYPE_WHITE = 0;
    public const TYPE_BLACK = 1;

    protected Pitch $pitch;
    protected bool $pressed;

    protected ?int $width = null;
    protected ?int $height = null;
    protected ?int $xAxis = null;
    protected ?int $yAxis = null;
    protected ?string $color = null;
    protected ?string $borderColor = null;

    public function __construct(Pitch $pitch, bool $pressed = false)
    {
        $this->pitch = $pitch;
        $this->pressed = $pressed;
    }

    public function getPitch(): Pitch
    {
        return $this->pitch;
    }

    public function isPressed(): bool
    {
        return $this->pressed;
    }

    public function setPressed(bool $pressed): void
    {
        $this->pressed = $pressed;
    }

    public function getType(): string
    {
        return $this->pitch->getAccidental() !== null ? self::TYPE_BLACK : self::TYPE_WHITE;
    }

    public function isWhiteKey(): bool
    {
        return $this->getType() === self::TYPE_WHITE;
    }

    public function isBlackKey(): bool
    {
        return $this->getType() === self::TYPE_BLACK;
    }

    public function isAccidental(): bool
    {
        return $this->isBlackKey();
    }

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    public function setBorderColor(?string $height): static
    {
        $this->height = $height;

        return $this;
    }
}
