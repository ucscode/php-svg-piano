<?php

namespace Ucscode\PhpSvgPiano\Pattern;

class TextPattern extends KeyPattern
{
    protected int $fontSize = 12;
    protected string $fontFamily = 'arial';

    public function setFontSize(int $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    public function setFontFamily(int $fontFamily): static
    {
        $this->fontFamily = $fontFamily;

        return $this;
    }

    public function getFontFamily(): string
    {
        return $this->fontFamily;
    }
}
