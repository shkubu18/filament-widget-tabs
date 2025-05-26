@php
    $widgetsPerRow = $this->getWidgetsPerRow();
@endphp

<div
    {{
        $attributes
            ->merge(['role' => 'tablist'])
            ->class([
                "fi-widget-tabs grid grid-cols-1 sm:grid-cols-2 md:grid-cols-$widgetsPerRow gap-4",
            ])
    }}
>
    {{ $slot }}
</div>
