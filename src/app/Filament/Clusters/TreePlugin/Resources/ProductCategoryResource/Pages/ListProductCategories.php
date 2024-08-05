<?php

namespace App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages;

use App\Filament\Clusters\TreePlugin\ProductCategoryResource;
use App\Filament\Widgets\ProductCategory;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\FilamentCmsInfo::make(['limit' => ['filament-tree'], 'showDemoLink' => false]),
            ProductCategory::class
        ];
    }
}
