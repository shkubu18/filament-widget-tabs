<?php

namespace Shkubu\FilamentWidgetTabs\Components;

use Closure;
use Filament\Support\Components\Component;
use Filament\Support\Concerns\HasExtraAttributes;
use Illuminate\Database\Eloquent\Builder;
use Shkubu\FilamentWidgetTabs\Components\Concerns\HasIcon;
use Shkubu\FilamentWidgetTabs\Components\Concerns\HasLabel;
use Shkubu\FilamentWidgetTabs\Components\Concerns\HasPercentage;
use Shkubu\FilamentWidgetTabs\Components\Concerns\HasPrecision;
use Shkubu\FilamentWidgetTabs\Components\Concerns\HasValue;

class WidgetTab extends Component
{
    use HasExtraAttributes;
    use HasIcon;
    use HasLabel;
    use HasPercentage;
    use HasPrecision;
    use HasValue;

    protected ?Closure $modifyQueryUsing = null;

    public function __construct(string | Closure | null $label = null)
    {
        $this->label($label);
    }

    public static function make(string | Closure | null $label = null): static
    {
        $static = app(static::class, ['label' => $label]);
        $static->configure();

        return $static;
    }

    public function query(?Closure $callback): static
    {
        $this->modifyQueryUsing($callback);

        return $this;
    }

    public function modifyQueryUsing(?Closure $callback): static
    {
        $this->modifyQueryUsing = $callback;

        return $this;
    }

    public function modifyQuery(Builder $query): Builder
    {
        return $this->evaluate($this->modifyQueryUsing, [
            'query' => $query,
        ]) ?? $query;
    }
}
