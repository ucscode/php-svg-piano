<?php

namespace Ucscode\PhpSvgPiano\Notation;

class PianoKey
{
    public const TYPE_WHITE = 0;
    public const TYPE_BLACK = 1;

    protected Pitch $pitch;
    protected bool $pressed;

    public function __construct(Pitch $pitch, bool $pressed = false)
    {
        $this->pitch = $pitch;
        $this->pressed = $pressed;
    }

    public function isPressed(): bool
    {
        return $this->pressed;
    }

    public function press(bool $pressed): void
    {
        $this->pressed = $pressed;
    }

    public function getType(): string
    {
        return $this->pitch->getAccidental() !== null ? self::TYPE_BLACK : self::TYPE_WHITE;
    }
}