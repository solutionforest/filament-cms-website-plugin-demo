<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductCategoryResource\Pages\ListProductCategories;
use App\Http\Livewire\CodeWrapper;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabContainer;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;


class DummyTabsWidget extends BaseWidget
{

    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Tab Plugin Label 1')
                ->icon('heroicon-o-bell')
                ->badge('39')
                ->schema([
                    TabContainer::make(CodeWrapper::class)->columnSpan(3)->data(['content' => "
TabLayoutTab::make('Tab Plugin Label 1')
->icon('heroicon-o-bell')
->badge('39')
->schema([
    TabContainer::make(AccountWidget::class)
        ->columnSpan(1),
    TabContainer::make(FilamentInfoWidget::class)
        ->columnSpan(2),
])->columns(4)"]),
                    TabContainer::make(AccountWidget::class)
                        ->columnSpan(1),
                    TabContainer::make(FilamentInfoWidget::class)
                        ->columnSpan(2),
                ])->columns(3),
            TabLayoutTab::make('Product Category Page')
                ->icon('heroicon-o-document')
                ->schema([
                    TabContainer::make(CodeWrapper::class)->columnSpanFull()->data(['content' => "
TabLayoutTab::make('Product Category Page')
->icon('heroicon-o-document')
->schema([
    TabContainer::make(ListProductCategories::class),
])"]),
                    TabContainer::make(ListProductCategories::class),
                ]),
            TabLayoutTab::make('Product Category')
                ->schema([
                    TabContainer::make(CodeWrapper::class)->columnSpanFull()->data(['content' => "
TabLayoutTab::make('Product Category')
->schema([
    \App\Filament\Tabs\Components\ProductCategory::make()
        ->columnSpanFull(),
    \App\Filament\Tabs\Components\AccountWidget::make()
        ->columnSpan(1),
    \App\Filament\Tabs\Components\FilamentInfoWidget::make()
        ->columnSpan(1),
])
->columns(2)"]),
                    \App\Filament\Tabs\Components\ProductCategory::make()
                        ->columnSpanFull(),
                    \App\Filament\Tabs\Components\AccountWidget::make()
                        ->columnSpan(1),
                    \App\Filament\Tabs\Components\FilamentInfoWidget::make()
                        ->columnSpan(1),
                ])
                ->columns(2),
            TabLayoutTab::make('Go To Filamentphp (Link)')->url("https://filamentphp.com/", true),
        ];
    }
}
