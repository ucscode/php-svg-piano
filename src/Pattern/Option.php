<?php

namespace Ucscode\PhpSvgPiano\Pattern;

use Ucscode\PhpSvgPiano\Traits\AttributesTrait;

class Option
{
    use AttributesTrait;

    public function __construct(array $options = [])
    {
        $this->attributes = $options;
    }
}