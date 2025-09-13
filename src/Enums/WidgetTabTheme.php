<?php

namespace Shkubu\FilamentWidgetTabs\Enums;

use Filament\Support\Contracts\HasLabel;

enum WidgetTabTheme: string implements HasLabel
{
    case Secondary = 'secondary';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
    case Info = 'info';

    public function getLabel(): string
    {
        return match ($this) {
            self::Secondary => 'Secondary',
            self::Success => 'Success',
            self::Warning => 'Warning',
            self::Danger => 'Danger',
            self::Info => 'Info',
        };
    }
}
