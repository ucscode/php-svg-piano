<?php

namespace Ucscode\PhpSvgPiano;

class Piano
{
    protected Configuration $configuration;

    public function __construct(?Configuration $configuration = null)
    {
        $this->configuration = $configuration ?? new Configuration();
    }

    public function render(?string $notes = null): string
    {
        return (new PianoBuilder($this->configuration, $notes))->render();
    }
}
