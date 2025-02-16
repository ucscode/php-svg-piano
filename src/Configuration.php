<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use Ucscode\PhpSvgPiano\Pattern\TextPattern;

class Configuration
{
    // [naturalKeyPattern.width] * 7 = [1 octave]
    // [naturalKeyPattern.height] = [piano.height]

    protected KeyPattern $naturalKeyPattern;
    protected KeyPattern $accidentalKeyPattern;
    protected TextPattern $titlePattern;
    protected TextPattern $watermarkPattern;

    public function __construct()
    {
        $this->naturalKeyPattern = (new KeyPattern(30, 90, '#353535ff', '#f9f9f9ff'))
            ->setTextPattern(new TextPattern(0, 0, '', '#353535ff'))
        ;

        $this->accidentalKeyPattern = (new KeyPattern(25, 55, '#272727ff', '#1a1a1aff'))
            ->setTextPattern(new TextPattern(0, 0, '', '#f9f9f9ff'))
        ;

        $this->titlePattern = (new TextPattern())->setFontSize(34);

        $this->watermarkPattern = new TextPattern();
    }

    public function setNaturalKeyPattern(KeyPattern $pattern): static
    {
        $this->naturalKeyPattern = $pattern;

        return $this;
    }

    public function getNaturalKeyPattern(): KeyPattern
    {
        return $this->naturalKeyPattern;
    }

    public function setAccidentalKeyPattern(KeyPattern $pattern): static
    {
        $this->accidentalKeyPattern = $pattern;

        return $this;
    }

    public function getAccidentalKeyPattern(): KeyPattern
    {
        return $this->accidentalKeyPattern;
    }

    public function setWatermarkPattern(TextPattern $pattern): static
    {
        $this->watermarkPattern = $pattern;

        return $this;
    }

    public function getWatermarkPattern(): TextPattern
    {
        return $this->watermarkPattern;
    }

    public function setTitlePattern(TextPattern $pattern): static
    {
        $this->titlePattern = $pattern;

        return $this;
    }

    public function getTitlePattern(): TextPattern
    {
        return $this->titlePattern;
    }
}
