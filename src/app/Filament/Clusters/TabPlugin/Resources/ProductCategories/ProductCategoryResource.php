<?php

namespace App\Filament\Clusters\TabPlugin\Resources\ProductCategories;

use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages\CreateProductCategory;
use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages\EditProductCategory;
use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages\ListProductCategories;
use App\Filament\Clusters\TabPlugin\TabPluginCluster;

class ProductCategoryResource extends \APp\Filament\Resources\ProductCategories\ProductCategoryResource
{
    protected static ?string $cluster = TabPluginCluster::class;
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
