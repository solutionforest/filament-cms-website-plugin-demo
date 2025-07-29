<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabContainer;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;

class DummyTabs extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Label 1')
                ->icon('heroicon-o-bell') 
                ->badge('39')
                ->schema([
                    // Display livewire component
                    TabContainer::make(\Filament\Widgets\AccountWidget::class),
                    // Display html
                    str('
## This is a dummy html code inside tab

- This is a bullet point
- Another bullet point
```php
echo "This is a code block";
```')->markdown()->toHtmlString(),

                    // Display livewire 
                    app(\App\Livewire\Dummy::class, ['__id' => uniqid() . '-dummy']),
                ]),
            TabLayoutTab::make('Label 2')
                ->schema([
                    // Display raw string
                    'Raw string here',

                    // Display livewire with filling data
                    TabContainer::make(\App\Filament\Resources\UserResource\Pages\ViewUser::class)  //TARGET COMPONENT
                        ->data(['record' => 1]),    // TARGET COMPONENT'S DATA

                    TabContainer::make(\Filament\Widgets\AccountWidget::class)
                        ->columnSpan(1),
                    TabContainer::make(\Filament\Widgets\AccountWidget::class)
                        ->columnSpan(1),
                ])
                ->columns(2),
            // Hyper link
            TabLayoutTab::make('Go To Filamentphp (Link)')->url("https://filamentphp.com/", true),
        ];
    }
}