<?php

namespace App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages;

use App\Filament\Clusters\TreePlugin\ProductCategoryResource;
use App\Filament\Widgets\FilamentCmsInfo;
use App\Filament\Widgets\ProductCategory;
use Filament\Actions\CreateAction;

class ListProductCategories extends \App\Filament\Resources\ProductCategories\Pages\ListProductCategories
{
    protected static string $resource = ProductCategoryResource::class;
    
    protected function getHeaderActions(): array
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