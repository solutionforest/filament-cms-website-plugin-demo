<?php

namespace App\Filament\Clusters\TreePlugin;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\ListProductCategories;
use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\CreateProductCategory;
use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\EditProductCategory;
use App\Filament\Clusters\TreePlugin;
use App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages;
use App\Models\ProductCategory;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder';

    // protected static ?string $navigationGroup = 'Tree-Plugin';

    protected static ?string $cluster = TreePlugin::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title'),
                TextColumn::make('order'),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
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
            'create' => CreateProductCategory::route('/create'),
            'edit' => EditProductCategory::route('/{record}/edit'),
        ];
    }
}
