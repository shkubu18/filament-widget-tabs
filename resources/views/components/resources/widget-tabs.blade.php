@if (count($widgetTabs = $this->getCachedWidgetTabs()))
    @php
        $activeWidgetTab = strval($this->activeWidgetTab);
        $renderHookScopes = $this->getRenderHookScopes();
    @endphp

    <div x-data="{
            widgetTab: $wire.$entangle('activeWidgetTab'),
            toggleWidgetTab(tabKey) {
                this.widgetTab = this.widgetTab === tabKey ? null : tabKey;
            }
        }"
    >
        <x-filament-widget-tabs::widget-tabs>
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_TABS_START, scopes: $renderHookScopes) }}
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABS_START, scopes: $renderHookScopes) }}

            @foreach ($widgetTabs as $widgetTabKey => $widgetTab)
                @php
                    $widgetTabKey = strval($widgetTabKey);
                @endphp

                <x-filament-widget-tabs::widget-tabs.item
                    :active="$activeWidgetTab === $widgetTabKey"
                    :alpine-active="'widgetTab === \'' . $widgetTabKey . '\''"
                    x-on:click="toggleWidgetTab('{{ $widgetTabKey }}')"
                    x-on:keydown.enter.prevent="toggleWidgetTab('{{ $widgetTabKey }}')"
                    x-on:keydown.space.prevent="toggleWidgetTab('{{ $widgetTabKey }}')"
                    :value="$widgetTab->getValue()"
                    :precision="$widgetTab->getPrecision()"
                    :icon="$widgetTab->getIcon()"
                    :iconSize="$widgetTab->getIconSize()"
                    :isPercentage="$widgetTab->isPercentage()"
                    :percentagePrecision="$widgetTab->getPercentagePrecision()"
                    :label="$widgetTab->getLabel() ?? $this->generateWidgetTabLabel($widgetTabKey)"
                    :theme-classes="$widgetTab->getThemeClasses()"
                    :attributes="$widgetTab->getExtraAttributeBag()"
                />
            @endforeach

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_TABS_END, scopes: $renderHookScopes) }}
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABS_END, scopes: $renderHookScopes) }}
        </x-filament-widget-tabs::widget-tabs>
    </div>
@endif
