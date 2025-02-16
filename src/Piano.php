<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Builder\PianoBuilder;
use Ucscode\PhpSvgPiano\Pattern\Option;

class Piano
{
    protected Configuration $configuration;

    public function __construct(?Configuration $configuration = null)
    {
        $this->configuration = $configuration ?? new Configuration();
    }

    public function render(?string $notes = null, ?Option $options = null): string
    {
        return (new PianoBuilder($this->configuration, $notes, $options ?? new Option()))->render();
    }
}
