<?php

namespace App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages;

use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\ProductCategoryResource;
use App\Filament\Widgets\DummyTabs;
use App\Filament\Widgets\FilamentCmsInfo;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FilamentCmsInfo::make(['limit' => ['tab-layout-plugin'], 'showDemoLink' => false]),
            
            DummyTabs::class,
        ];
    }
}
