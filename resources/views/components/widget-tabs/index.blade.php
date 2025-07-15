@php
    $widgetsPerRow = $this->getWidgetsPerRow();
    if (!is_array($widgetsPerRow)) {
        $widgetsPerRow = [
            'md' => $widgetsPerRow,
        ];
    }
    $columns = collect([
        ...[
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'lg' => null,
            'xl' => null,
            '2xl' => null,
        ],
        ...$widgetsPerRow,
    ]);
    $classes = $columns
        ->filter()
        ->keys()
        ->map(
            fn($key): string => str($key)
                ->whenIs(
                    'default',
                    fn($string) => $string->replace($key, 'grid-cols-[--cols-'),
                    fn($string) => $string->append(':grid-cols-[--cols-'),
                )
                ->append($key)
                ->finish(']')
                ->value(),
        )
        ->all();
    $columns = $columns
        ->mapWithKeys(
            fn($value, $key): array => [
                str($key)
                    ->start('--cols-')
                    ->append(': repeat(')
                    ->append($value)
                    ->finish(', minmax(0, 1fr))')
                    ->value() => $value,
            ],
        )
        ->filter()
        ->all();
@endphp

<div
    {{ $attributes
        ->merge(['role' => 'tablist'])
        ->class([
            'fi-widget-tabs grid',
            ...$classes,
            'gap-4'
            ])
            ->style($columns) }}>
    {{ $slot }}
</div>
