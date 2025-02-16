<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\SpacingTrait;
use Ucscode\PhpSvgPiano\Traits\StyleTrait;
use Ucscode\UssElement\Collection\Attributes;
use Ucscode\UssElement\Node\ElementNode;
use Ucscode\UssElement\Node\TextNode;

class TextBuilder
{
    use CoordinateTrait;
    use StyleTrait;
    use SpacingTrait;

    protected int $fontSize = 15;
    protected string $fontFamily = 'garamond';
    protected string $text;
    protected Attributes $attributes;

    public function __construct(?string $text, null|Attributes|array $attributes = null)
    {
        $this->text = $text ?? '';

        if (!$attributes instanceof Attributes) {
            $attributes = new Attributes($attributes ?? []);
        }

        $this->attributes = $attributes;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function render(): string
    {
        return $this->getElement()->render();
    }

    public function getElement(): ElementNode
    {
        $textAttributes = [
            'x' => $this->getSpaceLeft() + $this->getX(),
            'y' => $this->getSpaceTop() + $this->getY() + $this->getFontSize(),
            'fill' => $this->getFill() ?? '#00000',
            'font-size' => sprintf('%spx', $this->fontSize),
            'font-family' => $this->fontFamily,
        ] + $this->attributes->toArray();

        $node = new ElementNode('TEXT', $textAttributes);

        if (!empty($this->text)) {
            $node->appendChild(new TextNode($this->text));
        }

        return $node;
    }

    public function setFontSize(int $fontSize): static
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    public function getFontSize(): int
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

    public function getOuterHeight(): float
    {
        return empty($this->text) ? 0 : ($this->getSpaceY() + $this->fontSize);
    }
}
