<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Configuration;
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

    public function __construct(Pitch $pitch, bool $pressed = false, ?Attributes $attributes = null)
    {
        $this->pitch = $pitch;
        $this->pressed = $pressed;
        $this->attributes = $attributes ?? new Attributes([
            'class' => 'piano-key'
        ]);
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

    public function getAttributes(): Attributes
    {
        return $this->attributes;
    }

    public function setAttributes(Attributes $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function createElement(): ElementNode
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

        $textElementAttribute = [
            'x' => $this->getX() - 5,
            'y' => $this->getY() - 5,
            'fill' => $this->getFill(),
            'class' => '',
            'data-svg' => 'text-white'
        ];
        
        $svgRectNode = new ElementNode('RECT', $rectElementAttribute);
        $svgTextNode = new ElementNode('TEXT', $textElementAttribute);
        $textNode = new TextNode($this->getPitch()->getIdentifier());

        $svgRectNode->appendChild($svgTextNode);
        $svgTextNode->appendChild($textNode);

        return $svgRectNode;
    }
}
