<?php

namespace Shkubu\FilamentWidgetTabs\Components\Concerns;

use Closure;

trait HasValue
{
    protected string | int | float | Closure | null $value = null;

    public function value(string | int | float | Closure | null $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): string | int | float | null
    {
        return $this->evaluate($this->value);
    }
}
