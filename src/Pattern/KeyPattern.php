<?php

namespace Ucscode\PhpSvgPiano\Pattern;

class KeyPattern extends Pattern
{
    public TextPattern $textPattern;
    
    public function setTextPattern(TextPattern $pattern): static
    {
        $this->textPattern = $pattern;

        return $this;
    }

    public function getTextPattern(): TextPattern
    {
        return $this->textPattern;
    }
}