<?php

namespace Ucscode\PhpSvgPiano\Pattern;

use Ucscode\PhpSvgPiano\Enums\AccidentalCharEnum;

class TextPattern extends AbstractPattern
{
    protected int $fontSize = 10;
    protected string $fontFamily = 'arial';

    public function setFontSize(int $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getFontSize(): float
    {
        return $this->fontSize;
    }

    public function setFontFamily(string $fontFamily): static
    {
        $this->fontFamily = $fontFamily;

        return $this;
    }

    public function getFontFamily(): string
    {
        return $this->fontFamily;
    }

    public function estimateWidth(string $text): float
    {
        $averageChar = 0.6;

        if (strpos($text, AccidentalCharEnum::FLAT_SYMBOL->value) !== false || strpos($text, AccidentalCharEnum::SHARP_SYMBOL->value) !== false) {
            $averageChar = 0.35;
        }

        return strlen($text) * $this->fontSize * $averageChar;
    }
}
