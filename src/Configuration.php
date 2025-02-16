<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Enums\AccidentalTypeEnum;
use Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use Ucscode\PhpSvgPiano\Pattern\RenderPattern;
use Ucscode\PhpSvgPiano\Pattern\TextPattern;

class Configuration
{
    // [naturalKeyPattern.width] * 7 = [1 octave]
    // [naturalKeyPattern.height] = [piano.height]

    protected RenderPattern $naturalKeyPattern;
    protected RenderPattern $accidentalKeyPattern;
    protected TextPattern $titlePattern;
    protected TextPattern $watermarkPattern;
    protected AccidentalTypeEnum $defaultAccidentalType;

    public function __construct()
    {
        $this->naturalKeyPattern = (new RenderPattern())
            ->setReleasedKeyPattern(new KeyPattern(30, 90, '#353535ff', '#f9f9f9ff'))
            ->setPressedKeyPattern(new KeyPattern(30, 90, '#353535ff', '#d3bc5fff'))
            ->setReleasedTextPattern(new TextPattern(0, 0, '', '#353535ff'))
            ->setPressedTextPattern(new TextPattern(0, 0, '', '#353535ff'))
        ;

        $this->accidentalKeyPattern = (new RenderPattern())
            ->setReleasedKeyPattern(new KeyPattern(25, 55, '#272727ff', '#1a1a1aff'))
            ->setPressedKeyPattern(new KeyPattern(25, 55, '#272727ff', '#786721ff'))
            ->setReleasedTextPattern(new TextPattern(0, 0, '', '#f9f9f9ff'))
            ->setPressedTextPattern(new TextPattern(0, 0, '', '#f9f9f9ff'))
        ;

        $this->titlePattern = (new TextPattern())->setFontSize(34);
        $this->watermarkPattern = new TextPattern();
        $this->defaultAccidentalType = AccidentalTypeEnum::TYPE_SHARP;
    }

    public function setNaturalKeyPattern(RenderPattern $pattern): static
    {
        $this->naturalKeyPattern = $pattern;

        return $this;
    }

    public function getNaturalKeyPattern(): RenderPattern
    {
        return $this->naturalKeyPattern;
    }

    public function setAccidentalKeyPattern(RenderPattern $pattern): static
    {
        $this->accidentalKeyPattern = $pattern;

        return $this;
    }

    public function getAccidentalKeyPattern(): RenderPattern
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

    public function setDefaultAccidentalType(AccidentalTypeEnum $defaultAccidentalType)
    {
        if ($defaultAccidentalType === AccidentalTypeEnum::TYPE_NATURAL) {
            throw new \InvalidArgumentException('Natural type cannot be set as default accidental');
        }

        $this->defaultAccidentalType = $defaultAccidentalType;
    }

    public function getDefaultAccidentalType(): AccidentalTypeEnum
    {
        return $this->defaultAccidentalType;
    }
}
