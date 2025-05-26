<?php

namespace Shkubu\FilamentWidgetTabs\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Shkubu\FilamentWidgetTabs\Components\WidgetTab;

trait HasWidgetTabs
{
    #[Url]
    public ?string $activeWidgetTab = null;

    /**
     * @var array<string | int, WidgetTab>
     */
    protected array $cachedWidgetTabs;

    public function mount(): void
    {
        parent::mount();

        if ($this->shouldLoadDefaultActiveWidgetTab()) {
            $this->loadDefaultActiveWidgetTab();
        }
    }

    protected function shouldLoadDefaultActiveWidgetTab(): bool
    {
        return false;
    }

    protected function loadDefaultActiveWidgetTab(): void
    {
        if (filled($this->activeWidgetTab)) {
            return;
        }

        $this->activeWidgetTab = $this->getDefaultActiveWidgetTab();
    }

    public function getDefaultActiveWidgetTab(): string | int | null
    {
        return array_key_first($this->getCachedWidgetTabs());
    }

    /**
     * @return array<string | int, WidgetTab>
     */
    public function getCachedWidgetTabs(): array
    {
        return $this->cachedWidgetTabs ??= $this->getWidgetTabs();
    }

    /**
     * @return array<string | int, WidgetTab>
     */
    public function getWidgetTabs(): array
    {
        return [];
    }

    public function updatedActiveWidgetTab(): void
    {
        $this->resetPage();
    }

    public function updateActiveWidgetTabInstantly(string $widgetTab): void
    {
        $this->activeWidgetTab = $widgetTab;
    }

    public function generateWidgetTabLabel(string $key): string
    {
        return (string) str($key)
            ->replace(['_', '-'], ' ')
            ->ucfirst();
    }

    public function getWidgetsPerRow(): int
    {
        return 3;
    }

    protected function modifyQueryWithActiveTab(Builder $query): Builder
    {
        if (blank(filled($this->activeWidgetTab))) {
            return $query;
        }

        $widgetTabs = $this->getCachedWidgetTabs();

        if (! array_key_exists($this->activeWidgetTab, $widgetTabs)) {
            return $query;
        }

        return $widgetTabs[$this->activeWidgetTab]->modifyQuery($query);
    }
}
