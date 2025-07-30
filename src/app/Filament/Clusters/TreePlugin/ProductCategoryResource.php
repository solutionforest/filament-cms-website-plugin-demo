<?php

namespace App\Filament\Clusters\TreePlugin;

use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\CreateProductCategory;
use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\EditProductCategory;
use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\ListProductCategories;
use App\Filament\Clusters\TreePlugin\TreePluginCluster;

class ProductCategoryResource extends \App\Filament\Resources\ProductCategories\ProductCategoryResource
{
    protected static ?string $cluster = TreePluginCluster::class;

    protected static bool $shouldRegisterNavigation = true;

    public static function getPages(): array
    {
        return [
            'index' => ListProductCategories::route('/'),
            'create' => CreateProductCategory::route('/create'),
            'edit' => EditProductCategory::route('/{record}/edit'),
        ];
    }
}
