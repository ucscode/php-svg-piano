<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\ColorTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;

class PianoKey
{
    use DimensionTrait;
    use CoordinateTrait;
    use ColorTrait;

    public const TYPE_NATURAL = 0;
    public const TYPE_ACCIDENTAL = 1;

    protected Pitch $pitch;
    protected bool $pressed;

    public function __construct(Pitch $pitch, bool $pressed = false)
    {
        $this->pitch = $pitch;
        $this->pressed = $pressed;
        $this
            ->setFill($this->isAccidental() ? Configuration::ACCIDENTAL_KEY_FILL : Configuration::NATURAL_KEY_FILL)
            ->setStroke($this->isAccidental() ? Configuration::ACCIDENTAL_KEY_STROKE : Configuration::NATURAL_KEY_STROKE)
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
        return $this->pitch->getAccidental() !== null ? self::TYPE_ACCIDENTAL : self::TYPE_NATURAL;
    }

    public function isNatural(): bool
    {
        return $this->getType() === self::TYPE_NATURAL;
    }

    public function isAccidental(): bool
    {
        return $this->getType() === self::TYPE_ACCIDENTAL;
    }
}
