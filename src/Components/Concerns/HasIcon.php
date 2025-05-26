<?php

namespace Shkubu\FilamentWidgetTabs\Components\Concerns;

use Closure;
use Filament\Support\Enums\IconSize;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\HtmlString;

trait HasIcon
{
    protected string | Htmlable | Closure | null $icon = null;

    protected IconSize | string | Closure | null $iconSize = null;

    public function icon(string | Htmlable | Closure | null $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function iconSize(IconSize | string | Closure | null $size): static
    {
        $this->iconSize = $size;

        return $this;
    }

    public function getIcon(): string | Htmlable | null
    {
        $icon = $this->evaluate($this->icon);

        // https://github.com/filamentphp/filament/pull/13512
        if ($icon instanceof Renderable) {
            return new HtmlString($icon->render());
        }

        return $icon;
    }

    public function getIconSize(): IconSize | string | null
    {
        return $this->evaluate($this->iconSize);
    }
}
