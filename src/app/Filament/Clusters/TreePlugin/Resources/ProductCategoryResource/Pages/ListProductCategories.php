<?php

namespace App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Widgets\FilamentCmsInfo;
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
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FilamentCmsInfo::make(['limit' => ['filament-tree'], 'showDemoLink' => false]),
            ProductCategory::class
        ];
    }
}
