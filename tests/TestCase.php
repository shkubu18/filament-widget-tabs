<?php

namespace Shkubu\FilamentWidgetTabs\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Shkubu\FilamentWidgetTabs\FilamentWidgetTabsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return array_values(array_filter([
            class_exists(ActionsServiceProvider::class) ? ActionsServiceProvider::class : null,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            class_exists(FilamentServiceProvider::class) ? FilamentServiceProvider::class : null,
            class_exists(FormsServiceProvider::class) ? FormsServiceProvider::class : null,
            class_exists(InfolistsServiceProvider::class) ? InfolistsServiceProvider::class : null,
            LivewireServiceProvider::class,
            class_exists(NotificationsServiceProvider::class) ? NotificationsServiceProvider::class : null,
            class_exists(SupportServiceProvider::class) ? SupportServiceProvider::class : null,
            class_exists(TablesServiceProvider::class) ? TablesServiceProvider::class : null,
            class_exists(WidgetsServiceProvider::class) ? WidgetsServiceProvider::class : null,
            FilamentWidgetTabsServiceProvider::class,
        ]));
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-widget-tabs_table.php.stub';
        $migration->up();
        */
    }
}
