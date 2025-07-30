<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('parent_id')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('depth')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('title')
                    ->required(),
                TextInput::make('resource')->url(),
            ]);
    }
}
