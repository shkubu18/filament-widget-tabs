<?php

namespace Shkubu\FilamentWidgetTabs;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentWidgetTabsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-widget-tabs')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('filament-widget-tabs', __DIR__ . '/../resources/dist/filament-widget-tabs.css'),
        ], 'shkubu18/filament-widget-tabs');
    }
}
