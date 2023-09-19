<x-filament-widgets::widget class="fi-filament-cms-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">
                <a
                    href="{{ $this->getFilamentCmsPluginLink() }}"
                    target="_blank"
                    class="font-bold"
                >
                    Filament CMS Website Plugin
                </a>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Current Version
                </p>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    {{ $this->getFilamentCmsPluginInstallVersion() }}
                </p>
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
