<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Shkubu\FilamentWidgetTabs\Components\WidgetTab;
use Shkubu\FilamentWidgetTabs\Concerns\HasWidgetTabs;

class HasWidgetTabsBasePage
{
    public bool $parentMounted = false;

    public int $resetPageCalls = 0;

    public int $flushCachedTableRecordsCalls = 0;

    public function mount(): void
    {
        $this->parentMounted = true;
    }

    public function resetPage(): void
    {
        $this->resetPageCalls++;
    }

    protected function flushCachedTableRecords(): void
    {
        $this->flushCachedTableRecordsCalls++;
    }
}

class HasWidgetTabsCanonicalPage extends HasWidgetTabsBasePage
{
    use HasWidgetTabs;

    public bool $shouldLoadDefault = false;

    /**
     * @var array<string, WidgetTab>
     */
    public array $tabs = [];

    public function getWidgetTabs(): array
    {
        return $this->tabs;
    }

    protected function shouldLoadDefaultActiveWidgetTab(): bool
    {
        return $this->shouldLoadDefault;
    }

    public function callModifyQueryWithActiveTab(Builder $query, bool $isResolvingRecord = false): Builder
    {
        return $this->modifyQueryWithActiveTab($query, $isResolvingRecord);
    }
}

class HasWidgetTabsLegacyAliasPage extends HasWidgetTabsBasePage
{
    use HasWidgetTabs;

    public bool $shouldAutoLoadDefault = false;

    /**
     * @var array<string, WidgetTab>
     */
    public array $tabs = [];

    public function getWidgetTabs(): array
    {
        return $this->tabs;
    }

    protected function shouldAutoLoadDefaultActiveWidgetTab(): bool
    {
        return $this->shouldAutoLoadDefault;
    }
}

class HasWidgetTabsTestModel extends Model
{
    protected $table = 'has_widget_tabs_test_models';

    public $timestamps = false;
}

it('loads the default active tab via canonical method', function () {
    $page = new HasWidgetTabsCanonicalPage;
    $page->shouldLoadDefault = true;
    $page->tabs = [
        'all' => WidgetTab::make()->label('All'),
        'published' => WidgetTab::make()->label('Published'),
    ];

    $page->mount();

    expect($page->parentMounted)->toBeTrue();
    expect($page->activeWidgetTab)->toBe('all');
});

it('loads the default active tab via legacy alias method', function () {
    $page = new HasWidgetTabsLegacyAliasPage;
    $page->shouldAutoLoadDefault = true;
    $page->tabs = [
        'all' => WidgetTab::make()->label('All'),
        'published' => WidgetTab::make()->label('Published'),
    ];

    $page->mount();

    expect($page->activeWidgetTab)->toBe('all');
});

it('resets pagination and cached records when active widget tab changes', function () {
    $page = new HasWidgetTabsCanonicalPage;

    $page->updatedActiveWidgetTab();

    expect($page->resetPageCalls)->toBe(1);
    expect($page->flushCachedTableRecordsCalls)->toBe(1);
});

it('bypasses widget query modification while resolving records when configured', function () {
    $page = new HasWidgetTabsCanonicalPage;
    $page->activeWidgetTab = 'published';
    $page->tabs = [
        'published' => WidgetTab::make()
            ->query(fn (Builder $query): Builder => $query->where('status', 'published'))
            ->excludeQueryWhenResolvingRecord(),
    ];

    $query = (new HasWidgetTabsTestModel)->newQuery();

    $page->callModifyQueryWithActiveTab($query, true);

    expect($query->getQuery()->wheres ?? [])->toBeArray()->toHaveCount(0);
});

it('applies widget query modification outside record resolution', function () {
    $page = new HasWidgetTabsCanonicalPage;
    $page->activeWidgetTab = 'published';
    $page->tabs = [
        'published' => WidgetTab::make()
            ->query(fn (Builder $query): Builder => $query->where('status', 'published'))
            ->excludeQueryWhenResolvingRecord(),
    ];

    $query = (new HasWidgetTabsTestModel)->newQuery();

    $page->callModifyQueryWithActiveTab($query, false);

    expect($query->getQuery()->wheres)->toBeArray()->toHaveCount(1);
});
