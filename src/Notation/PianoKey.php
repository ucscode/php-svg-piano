<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use Ucscode\PhpSvgPiano\Pattern\TextPattern;
use Ucscode\PhpSvgPiano\Traits\AxisMethodsTrait;
use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\StyleTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;
use Ucscode\UssElement\Collection\Attributes;
use Ucscode\UssElement\Node\ElementNode;
use Ucscode\UssElement\Node\TextNode;

class PianoKey
{
    use DimensionTrait;
    use CoordinateTrait;
    use StyleTrait;
    use AxisMethodsTrait;

    public const TYPE_NATURAL = 0;
    public const TYPE_ACCIDENTAL = 1;

    protected Pitch $pitch;
    protected bool $pressed;
    protected Attributes $attributes;
    protected TextPattern $textPattern;

    public function __construct(Pitch $pitch, bool $pressed = false, ?Attributes $attributes = null)
    {
        $this->pitch = $pitch;
        $this->pressed = $pressed;
        $this->textPattern = new TextPattern();
        $this->attributes = $attributes ?? new Attributes([
            'class' => 'piano-key'
        ]);

        $pattern = $this->isAccidental() ?
            (new Configuration())->getAccidentalKeyPattern() :
            (new Configuration())->getNaturalKeyPattern()
        ;

        $this->configurePianoPattern($pattern);
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

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }

    public function setAttributes(Attributes $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function setTextPattern(TextPattern $pattern): static
    {
        $this->textPattern = $pattern;

        return $this;
    }

    public function getTextPattern(): TextPattern
    {
        return $this->textPattern;
    }

    public function createKeyElement(): ElementNode
    {
        $rectElementAttribute = [
            'fill' => $this->getFill(),
            'stroke' => $this->getStroke(),
            'x' => $this->getX(),
            'y' => $this->getY(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'stroke-width' => $this->getStrokeWidth(),
        ] + $this->getAttributes()->toArray();

        return new ElementNode('RECT', $rectElementAttribute);
    }

    public function createTextElement(): ElementNode
    {
        $textElementAttribute = [
            'x' => $this->getX(),
            'y' => $this->getHeight(),
            'fill' => $this->getTextPattern()->getFill(),
            'stroke' => $this->getTextPattern()->getStroke(),
            'stroke-width' => $this->getTextPattern()->getStrokeWidth(),
            'font-size' => $this->getTextPattern()->getFontSize(),
            'font-family' => $this->getTextPattern()->getFontFamily(),
            'class' => '',
            'data-svg' => 'text-white'
        ];

        $svgTextNode = new ElementNode('TEXT', $textElementAttribute);
        $svgTextNode->appendChild(new TextNode($this->getPitch()->getIdentifier()));

        return $svgTextNode;
    }

    private function configurePianoPattern(KeyPattern $pattern): void
    {
        $this
            ->setFill($pattern->getFill())
            ->setStroke($pattern->getStroke())
            ->setStrokeWidth($pattern->getStrokeWidth())
        ;

        $textPattern = $pattern->getTextPattern();
        
        $this->textPattern
            ->setFill($textPattern->getFill())
            ->setStroke($textPattern->getStroke())
            ->setStrokeWidth($textPattern->getStrokeWidth())
        ;
    }
}
