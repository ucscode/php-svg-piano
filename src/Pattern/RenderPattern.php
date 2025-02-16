<?php

namespace Ucscode\PhpSvgPiano\Pattern;

class RenderPattern
{
    protected KeyPattern $releasedKeyPattern;
    protected KeyPattern $pressedKeyPattern;
    protected TextPattern $releasedTextPattern;
    protected TextPattern $pressedTextPattern;

    public function __construct()
    {
    }

    public function setReleasedKeyPattern(KeyPattern $keyPattern): static
    {
        $this->releasedKeyPattern = $keyPattern;

        return $this;
    }

    public function getReleasedKeyPattern(): KeyPattern
    {
        return $this->releasedKeyPattern;
    }

    public function setPressedKeyPattern(KeyPattern $keyPattern): static
    {
        $this->pressedKeyPattern = $keyPattern;

        return $this;
    }

    public function getPressedKeyPattern(): KeyPattern
    {
        return $this->pressedKeyPattern;
    }

    public function setReleasedTextPattern(TextPattern $textPattern): static
    {
        $this->releasedTextPattern = $textPattern;

        return $this;
    }

    public function getReleasedTextPattern(): TextPattern
    {
        return $this->releasedTextPattern;
    }

    public function setPressedTextPattern(TextPattern $textPattern): static
    {
        $this->pressedTextPattern = $textPattern;

        return $this;
    }

    public function getPressedTextPattern(): TextPattern
    {
        return $this->pressedTextPattern;
    }
}
