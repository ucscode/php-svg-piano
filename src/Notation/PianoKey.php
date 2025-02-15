<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Traits\AxisTrait;
use Ucscode\PhpSvgPiano\Traits\ColorTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;

class PianoKey
{
    use DimensionTrait;
    use AxisTrait;
    use ColorTrait;

    public const TYPE_WHITE = 0;
    public const TYPE_BLACK = 1;

    protected Pitch $pitch;
    protected bool $pressed;

    public function __construct(Pitch $pitch, bool $pressed = false)
    {
        $this->pitch = $pitch;
        $this->pressed = $pressed;
        $this
            ->setFill($this->isAccidental() ? '#000' : '#fff')
            ->setStroke('#000')
        ;
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

    public function getType(): int
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
}
