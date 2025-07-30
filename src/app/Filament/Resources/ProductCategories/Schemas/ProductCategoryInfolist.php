<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('parent_id')
                    ->numeric(),
                TextEntry::make('order')
                    ->numeric(),
                TextEntry::make('depth')
                    ->numeric(),
                TextEntry::make('title'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('resource'),
            ]);
    }
}
