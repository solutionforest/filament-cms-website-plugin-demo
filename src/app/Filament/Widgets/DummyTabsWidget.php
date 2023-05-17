<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
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
                    "This is widgets => [ new AccountWidget() + new FilamentInfoWidget() ] ",
                    new AccountWidget(),
                    new FilamentInfoWidget()
                ]),
            TabLayoutTab::make('Product Category')
                ->schema([
                    "This is widgets => [ new ProductCategory() + new AccountWidget() + new FilamentInfoWidget() ] ",
                    new ProductCategory(),
                    new AccountWidget(),
                    new FilamentInfoWidget(),
                ]),
            TabLayoutTab::make('Go To Filamentphp (Link)')->url("https://filamentphp.com/", true),
        ];
    }
}
