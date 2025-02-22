<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use Ucscode\PhpSvgPiano\Pattern\RenderPattern;
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
    protected bool $pressed = false;
    protected Attributes $attributes;
    protected Attributes $textAttributes;
    protected TextPattern $textPattern;
    protected Configuration $configuration;

    public function __construct(Pitch $pitch, ?Configuration $configuration = null)
    {
        $this->pitch = $pitch;
        $this->textPattern = new TextPattern();
        $this->attributes = new Attributes(['class' => 'piano-key']);
        $this->textAttributes = new Attributes(['class' => 'piano-text']);

        $this->configuration ??= new Configuration();

        $pattern = $this->isAccidental() ?
            $configuration->getAccidentalKeyPattern() :
            $configuration->getNaturalKeyPattern()
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

    public function setPressed(bool $pressed): static
    {
        $this->pressed = $pressed;

        return $this;
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

    public function getTextAttributes(): Attributes
    {
        return $this->textAttributes;
    }

    public function setTextAttributes(Attributes $attributes): static
    {
        $this->textAttributes = $attributes;

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
        $keyText = $this->configuration->getShowOctaveNumber() ?
            $this->getPitch()->getIdentifier() :
            $this->getPitch()->getAccidentalNote()
        ;

        $spaceDiff = $this->getWidth() - $this->getTextPattern()->estimateWidth($keyText);
        // (half space) [element width] (half space)
        $halfSpace = $spaceDiff / 2;

        $textElementAttribute = [
            'x' => $this->getX() + $halfSpace,
            'y' => $this->getBottom() * 0.92,
            'fill' => $this->getTextPattern()->getFill(),
            'stroke' => $this->getTextPattern()->getStroke(),
            'stroke-width' => $this->getTextPattern()->getStrokeWidth(),
            'font-size' => $this->getTextPattern()->getFontSize(),
            'font-family' => $this->getTextPattern()->getFontFamily(),
        ] + $this->getTextAttributes()->toArray();

        $svgTextNode = new ElementNode('TEXT', $textElementAttribute);
        $svgTextNode->appendChild(new TextNode($keyText));

        return $svgTextNode;
    }

    private function configurePianoPattern(RenderPattern $pattern): void
    {
        $keyPattern = $this->isPressed() ? $pattern->getPressedKeyPattern() : $pattern->getReleasedKeyPattern();

        $this
            ->setFill($keyPattern->getFill())
            ->setStroke($keyPattern->getStroke())
            ->setStrokeWidth($keyPattern->getStrokeWidth())
        ;

        $textPattern = $this->isPressed() ? $pattern->getPressedTextPattern() : $pattern->getReleasedTextPattern();

        $this->textPattern
            ->setFill($textPattern->getFill())
            ->setStroke($textPattern->getStroke())
            ->setStrokeWidth($textPattern->getStrokeWidth())
        ;
    }
}
