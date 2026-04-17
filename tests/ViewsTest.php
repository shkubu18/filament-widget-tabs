<?php

it('does not reset table filters when toggling tabs in the resource view', function () {
    $view = file_get_contents(__DIR__ . '/../resources/views/components/resources/widget-tabs.blade.php');

    expect($view)->not->toContain('resetTable(');
});

it('binds accessibility state in the widget tab item view', function () {
    $view = file_get_contents(__DIR__ . '/../resources/views/components/widget-tabs/item.blade.php');

    expect($view)->toContain('aria-selected');
    expect($view)->toContain('x-bind:aria-selected');
});
