<?php

namespace Shkubu\FilamentWidgetTabs;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentWidgetTabsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-widget-tabs')
            ->hasAssets()
            ->hasViews();
    }
}
