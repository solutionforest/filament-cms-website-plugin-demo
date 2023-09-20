<x-filament-widgets::widget class="fi-filament-cms-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">
                @foreach ($this->getPluginInfos() ?? [] as $pluginInfo)
                    @php
                        $pluginUrl = data_get($pluginInfo, 'url');
                        $name = data_get($pluginInfo, 'name');
                        $version = data_get($pluginInfo, 'version');
                    @endphp
                    <div>
                        <a href="{{ $pluginUrl }}" target="_blank" class="mt-2">
                            <span class="text-sm mr-2">
                                {{ $name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $version }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col items-end gap-y-1">
                <x-filament::link
                    color="gray"
                    href="{{ $this->getFilamentCmsPluginDocLink() }}"
                    icon="heroicon-m-book-open"
                    icon-alias="panels::widgets.filament-info.open-documentation-button"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    {{ __('filament-panels::widgets/filament-info-widget.actions.open_documentation.label') }}
                </x-filament::link>

            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
