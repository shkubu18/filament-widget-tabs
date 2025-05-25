<?php

namespace Shkubu\FilamentWidgetTabs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Shkubu\FilamentWidgetTabs\FilamentWidgetTabs
 */
class FilamentWidgetTabs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Shkubu\FilamentWidgetTabs\FilamentWidgetTabs::class;
    }
}
