<?php

namespace Shkubu\FilamentWidgetTabs\Commands;

use Illuminate\Console\Command;

class FilamentWidgetTabsCommand extends Command
{
    public $signature = 'filament-widget-tabs';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
