<?php

namespace Shkubu\FilamentWidgetTabs\Components\Concerns;

use Closure;
use Shkubu\FilamentWidgetTabs\Enums\WidgetTabTheme;

trait HasTheme
{
    protected WidgetTabTheme | string | Closure | null $theme = null;

    protected bool $gradient = false;

    protected array | Closure | null $customThemeClasses = null;

    public function success(): static
    {
        $this->theme(WidgetTabTheme::Success);

        return $this;
    }

    public function theme(WidgetTabTheme | string | Closure | null $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function warning(): static
    {
        $this->theme(WidgetTabTheme::Warning);

        return $this;
    }

    public function danger(): static
    {
        $this->theme(WidgetTabTheme::Danger);

        return $this;
    }

    public function info(): static
    {
        $this->theme(WidgetTabTheme::Info);

        return $this;
    }

    public function secondary(): static
    {
        $this->theme(WidgetTabTheme::Secondary);

        return $this;
    }

    public function gradient(bool $condition = true): static
    {
        $this->gradient = $condition;

        return $this;
    }

    public function customThemeClasses(array | Closure | null $classes): static
    {
        $this->customThemeClasses = $classes;

        return $this;
    }

    public function getThemeClasses(): array
    {
        $theme = $this->getTheme();
        $classes = [];

        if ($theme instanceof WidgetTabTheme) {
            $classes[] = "fi-widget-tab-$theme->value";

            if ($this->hasGradient()) {
                $classes[] = 'fi-widget-tab-gradient';
            }
        } elseif (is_string($theme)) {
            $classes[] = "fi-widget-tab-$theme";

            if ($this->hasGradient()) {
                $classes[] = 'fi-widget-tab-gradient';
            }
        }

        return array_merge($classes, $this->getCustomThemeClasses());
    }

    public function getTheme(): WidgetTabTheme | string | null
    {
        return $this->evaluate($this->theme);
    }

    public function hasGradient(): bool
    {
        return $this->gradient;
    }

    public function getCustomThemeClasses(): array
    {
        return $this->evaluate($this->customThemeClasses) ?? [];
    }
}
