<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Schemas\Components\LivewireContainer;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;

class DummyTabs extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Demo')
                ->icon('heroicon-o-bell') 
                ->badge('39')
                ->schema([
                    // Display livewire component
                    LivewireContainer::make(\Filament\Widgets\AccountWidget::class),

                    // Disply raw string
                    'This is a raw string',

                    // Display livewire 
                    app(\App\Livewire\Dummy::class, ['__id' => uniqid() . '-dummy']),
                    

                    // Display livewire with filling data
                    LivewireContainer::make(\App\Filament\Resources\ProductCategories\Pages\ListProductCategories::class)  //TARGET COMPONENT
                        ->data(['tableSearch' => 'dress']),    // TARGET COMPONENT'S DATA
                ]),

            TabLayoutTab::make('Source Code')
                ->schema([
                    // Display html
                    str($this->demoSourceCode())
                        ->markdown()
                        ->wrap('<div class="prose rounded-xl shadow-sm" style="overflow: auto; padding: 12px; background-color: var(--gray-700); color: white;">', '</div>')
                        ->toHtmlString(),
                ]),

            // Hyper link
            TabLayoutTab::make('Go To Filamentphp (Link)')
                ->url("https://filamentphp.com/", true),
        ];
    }

    protected function demoSourceCode(): string
    {
        return <<<'EOL'
```php
<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Schemas\Components\LivewireContainer;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabContainer;

class DummyTabs extends BaseWidget
{
    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Demo')
                ->icon('heroicon-o-bell') 
                ->badge('39')
                ->schema([
                    // Display livewire component
                    LivewireContainer::make(\Filament\Widgets\AccountWidget::class),

                    // Disply raw string
                    'This is a raw string',

                    // Display livewire 
                    app(\App\Livewire\Dummy::class, ['__id' => uniqid() . '-dummy']),
                    

                    // Display livewire with filling data
                    LivewireContainer::make(\App\Filament\Resources\ProductCategories\Pages\ListProductCategories::class)  //TARGET COMPONENT
                        ->data(['tableSearch' => 'dress']),    // TARGET COMPONENT'S DATA
                ]),

            TabLayoutTab::make('Source Code')
                ->schema([
                    // Display html
                    str($this->demoSourceCode())
                        ->markdown()
                        ->wrap('<div class="prose rounded-xl shadow-sm" style="overflow: auto; padding: 12px; background-color: var(--gray-700); color: white;">', '</div>')
                        ->toHtmlString(),
                ]),

            // Hyper link
            TabLayoutTab::make('Go To Filamentphp (Link)')
                ->url("https://filamentphp.com/", true),
        ];
    }
}
```
EOL;
    }
}