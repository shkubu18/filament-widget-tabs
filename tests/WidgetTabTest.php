<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Shkubu\FilamentWidgetTabs\Components\WidgetTab;

class WidgetTabTestModel extends Model
{
    protected $table = 'widget_tab_test_models';

    public $timestamps = false;
}

it('can apply query modifications', function () {
    $tab = WidgetTab::make()
        ->query(fn (Builder $query): Builder => $query->where('status', 'published'));

    $query = (new WidgetTabTestModel)->newQuery();

    $modifiedQuery = $tab->modifyQuery($query);

    expect($modifiedQuery->getQuery()->wheres)->toBeArray()->toHaveCount(1);
});

it('supports excluding query when resolving records', function () {
    $tab = WidgetTab::make()->excludeQueryWhenResolvingRecord();

    expect($tab->isQueryExcludedWhenResolvingRecord())->toBeTrue();
});

it('supports closure values for percentage state and precision', function () {
    $tab = WidgetTab::make()
        ->value(42)
        ->percentage(fn (): bool => true)
        ->percentagePrecision(fn (): int => 2);

    expect($tab->isPercentage())->toBeTrue();
    expect($tab->getPercentagePrecision())->toBe(2);
});
