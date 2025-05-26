<?php

namespace Shkubu\FilamentWidgetTabs\Components\Concerns;

use Closure;

trait HasPercentage
{
    protected bool $isPercentage = false;

    protected int $percentagePrecision = 0;

    public function percentage(bool | Closure $condition = true): static
    {
        $this->isPercentage = $condition;

        return $this;
    }

    public function isPercentage(): bool
    {
        return $this->evaluate($this->isPercentage);
    }

    public function percentagePrecision(int | Closure $precision): static
    {
        $this->percentagePrecision = $precision;

        return $this;
    }

    public function getPercentagePrecision(): int
    {
        return $this->evaluate($this->percentagePrecision);
    }
}
