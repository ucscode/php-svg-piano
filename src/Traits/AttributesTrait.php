<?php

namespace Ucscode\PhpSvgPiano\Traits;

trait AttributesTrait
{
    protected array $attributes = [];

    public function set(string $name, mixed $value): static
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    public function remove(string $name): static
    {
        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }

        return $this;
    }
}
