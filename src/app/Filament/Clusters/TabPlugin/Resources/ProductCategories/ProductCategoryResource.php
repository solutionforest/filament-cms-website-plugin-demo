<?php

namespace App\Filament\Clusters\TabPlugin\Resources\ProductCategories;

use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages\CreateProductCategory;
use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages\EditProductCategory;
use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Pages\ListProductCategories;
use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Schemas\ProductCategoryForm;
use App\Filament\Clusters\TabPlugin\Resources\ProductCategories\Tables\ProductCategoriesTable;
use App\Filament\Clusters\TabPlugin\TabPluginCluster;
use App\Models\ProductCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = TabPluginCluster::class;

    public static function form(Schema $schema): Schema
    {
        return ProductCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductCategories::route('/'),
        ];
    }
}
