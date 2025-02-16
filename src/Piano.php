<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Builder\PianoBuilder;
use Ucscode\PhpSvgPiano\Builder\Option;

class Piano
{
    protected Configuration $configuration;

    public function __construct(?Configuration $configuration = null)
    {
        $this->configuration = $configuration ?? new Configuration();
    }

    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    public function render(?string $notes = null, null|string|Option|array $option = null): string
    {
        if (!$option instanceof Option) {
            if (is_string($option)) {
                $option = ['title' => $option];
            }

            $option = new Option($option ??= []);
        }

        return (new PianoBuilder($this->configuration, $notes, $option))->render();
    }
}
