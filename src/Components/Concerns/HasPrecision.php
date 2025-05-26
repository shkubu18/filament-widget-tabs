<?php

namespace Shkubu\FilamentWidgetTabs\Components\Concerns;

use Closure;

trait HasPrecision
{
    protected int | Closure $precision = 0;

    public function precision(int | Closure $precision): static
    {
        $this->precision = $precision;

        return $this;
    }

    public function getPrecision(): int
    {
        return $this->evaluate($this->precision);
    }
}
