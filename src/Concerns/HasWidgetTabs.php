<?php

namespace Shkubu\FilamentWidgetTabs\Concerns;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
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

    public static function bootHasWidgetTabs(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE,
            fn (): View => view('filament-widget-tabs::components.resources.widget-tabs'),
            scopes: static::class,
        );
    }

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

    /**
     * Use an integer value, or an array with breakpoints and integer values
     *  ['sm'=>2, 'md'=>3, 'lg'=>4] or 3
     *
     * @return int|array<string, int>
     */
    public function getWidgetsPerRow(): int | array
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
