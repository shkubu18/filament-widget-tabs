@php
    use Filament\Support\Enums\IconSize;
    use Illuminate\Support\Number;
@endphp

@props([
    'active' => false,
    'alpineActive' => null,
    'icon' => null,
    'iconSize' => IconSize::Medium,
    'isPercentage',
    'label' => null,
    'value' => null,
    'precision',
    'percentagePrecision',
    'themeClasses' => [],
])

@php
    $isAlpineActive = filled($alpineActive);
@endphp

<div
    @if ($isAlpineActive)
        x-bind:class="{
            'fi-inactive': ! ({{ $alpineActive }}),
            'fi-active': {{ $alpineActive }}
        }"
    @endif
    {{ $attributes->merge(['aria-selected' => $active, 'role' => 'tab'])->class(array_merge(['fi-widget-tab'], $themeClasses)) }}
>
    <div class="flex items-center gap-x-6">
        @if($icon)
            <div
                class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shadow-md"
            >
                <x-filament::icon
                    :icon="$icon"
                    @class([
                      'fi-widget-tab-icon',
                      match ($iconSize) {
                          IconSize::Small, 'sm' => 'h-4 w-4',
                          IconSize::Medium, 'md' => 'h-6 w-6',
                          IconSize::Large, 'lg' => 'h-8 w-8',
                          default => $iconSize,
                        },
                    ])
                />
            </div>
        @endif
    </div>
    <div class="flex flex-col">
        <span class="font-medium text-sm label">{{ $label }}</span>
        <span class="text-2xl font-bold value">
            {{ is_numeric($value)
                ? ($isPercentage
                    ? Number::percentage($value, $percentagePrecision)
                    : Number::format($value, $precision))
                : $value
            }}
        </span>
    </div>
</div>
