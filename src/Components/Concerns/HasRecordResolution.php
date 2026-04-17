<?php

namespace Shkubu\FilamentWidgetTabs\Components\Concerns;

use Closure;

trait HasRecordResolution
{
    protected bool | Closure $excludeQueryWhenResolvingRecord = false;

    public function excludeQueryWhenResolvingRecord(bool | Closure $condition = true): static
    {
        $this->excludeQueryWhenResolvingRecord = $condition;

        return $this;
    }

    public function isQueryExcludedWhenResolvingRecord(): bool
    {
        return (bool) $this->evaluate($this->excludeQueryWhenResolvingRecord);
    }
}
