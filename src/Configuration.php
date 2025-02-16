<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Pattern\Pattern;
use Ucscode\PhpSvgPiano\Pattern\TextPattern;

class Configuration
{
    // [naturalKeyPattern.width] * 7 = [1 octave]
    // [naturalKeyPattern.height] = [piano.height]ssssss

    protected Pattern $naturalKeyPattern;
    protected Pattern $accidentalKeyPattern;
    protected TextPattern $titlePattern;
    protected TextPattern $watermarkPattern;

    public function __construct()
    {
        $this->naturalKeyPattern = new Pattern(30, 90, '#353535ff', '#f9f9f9ff');
        $this->accidentalKeyPattern = new Pattern(25, 55, '#272727ff', '#1a1a1aff');
        $this->titlePattern = (new TextPattern())->setFontSize(34);
        $this->watermarkPattern = new TextPattern();
    }

    public function setNaturalKeyPattern(Pattern $pattern): static
    {
        $this->naturalKeyPattern = $pattern;

        return $this;
    }

    public function getNaturalKeyPattern(): Pattern
    {
        return $this->naturalKeyPattern;
    }

    public function setAccidentalKeyPattern(Pattern $pattern): static
    {
        $this->accidentalKeyPattern = $pattern;

        return $this;
    }

    public function getAccidentalKeyPattern(): Pattern
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
