<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Builder\PianoBuilder;

class Piano
{
    protected Configuration $configuration;

    public function __construct(?Configuration $configuration = null)
    {
        $this->configuration = $configuration ?? new Configuration();
    }

    public function render(?string $notes = null, array $options = []): string
    {
        return (new PianoBuilder($this->configuration, $notes, $options))->render();
    }
}
