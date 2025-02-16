<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\StyleTrait;
use Ucscode\UssElement\Node\ElementNode;

class TextBuilder
{
    use CoordinateTrait;
    use StyleTrait;

    protected int $fontSize = 10;
    protected string $fontFamily = 'garamond';
    protected ?string $label = '';
    protected string $text;

    public function __construct(?string $text)
    {
        $this->text = $text ?? '';
    }

    public function render(): string
    {
        return $this->getElement()->render();
    }

    public function getElement(): ElementNode
    {
        $node = new ElementNode('text', [
            'x' => $this->x ?? 0,
            'y' => $this->y + $this->fontSize,
            'fill' => $this->getFill() ?? '#00000',
            'font-size' => sprintf('%spx', $this->fontSize),
            'font-family' => $this->fontFamily,
            'data-label' => $this->label
        ]);

        if (!empty($this->text)) {
            $node->setInnerHtml($this->text);
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

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
