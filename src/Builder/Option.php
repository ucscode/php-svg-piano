<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Traits\AttributesTrait;

class Option
{
    use AttributesTrait;

    public function __construct(array $options = [])
    {
        $this->attributes = $options;
    }
}
