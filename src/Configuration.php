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
    protected AccidentalTypeEnum $defaultAccidentalType;
    protected int $octaveStartPoint = 4;
    protected int $octaveEndPoint = 4;
    protected bool $showReleasedKeyText = false;
    protected bool $showPressedKeyText = true;
    protected bool $showOctaveNumber = true;

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

        $this->titlePattern = (new TextPattern())->setFontSize(16);
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

    public function setOctaveStartPoint(int $octaveStartPoint): static
    {
        $this->octaveStartPoint = $octaveStartPoint;

        return $this;
    }

    public function getOctaveStartPoint(): int
    {
        return $this->octaveStartPoint;
    }

    public function setOctaveEndPoint(int $octaveEndPoint): static
    {
        $this->octaveEndPoint = $octaveEndPoint;

        return $this;
    }

    public function getOctaveEndPoint(): int
    {
        return $this->octaveEndPoint;
    }

    public function setShowReleasedKeyText(bool $showReleasedKeyText): static
    {
        $this->showReleasedKeyText = $showReleasedKeyText;

        return $this;
    }

    public function getShowReleasedKeyText(): bool
    {
        return $this->showReleasedKeyText;
    }

    public function setShowPressedKeyText(bool $showPressedKeyText): static
    {
        $this->showPressedKeyText = $showPressedKeyText;

        return $this;
    }

    public function getShowPressedKeyText(): bool
    {
        return $this->showPressedKeyText;
    }

    public function setShowOctaveNumber(bool $showOctaveNumber): static
    {
        $this->showOctaveNumber = $showOctaveNumber;

        return $this;
    }

    public function getShowOctaveNumber(): bool
    {
        return $this->showOctaveNumber;
    }
}
