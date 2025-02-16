<?php

namespace Ucscode\PhpSvgPiano\Builder;

class Group
{
    protected array $group = [];

    public function add(string $name, mixed $value): static
    {
        $this->group[$name] = $value;

        return $this;
    }

    public function get(string $name): mixed
    {
        return $this->group[$name] ?? null;
    }

    public function remove(string $name): static
    {
        if (array_key_exists($name, $this->group)) {
            unset($this->group[$name]);
        }
        
        return $this;
    }
}