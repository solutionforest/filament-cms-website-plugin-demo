<?php

namespace App\Filament\Clusters\SimpleLightBoxPlugin\Resources;

use App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource\Pages\ManageProductCategories;
use App\Filament\Clusters\SimpleLightBoxPlugin\SimpleLightBoxPluginCluster;
use App\Models\ProductCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCategoryResource extends \App\Filament\Resources\ProductCategories\ProductCategoryResource
{
    protected static ?string $cluster = SimpleLightBoxPluginCluster::class;

    protected static bool $shouldRegisterNavigation = true;

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                TextEntry::make('id'),
                TextEntry::make('title'),

                TextEntry::make('resource')
                    ->simpleLightbox(fn ($record) => $record->resource),

                Section::make('PDF')
                    ->aside()
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('pdf')
                            ->label('PDF (defaultDisplayUrl as false and default value as "No PDF")')
                            ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: false)
                            ->default(fn ($record) => $record->id % 2 == 0 ? 'View PDF' : 'No PDF'),
                        TextEntry::make('pdf_2')
                            ->label('PDF (defaultDisplayUrl as true) demo')
                            ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: true),
                    ]),
                ImageEntry::make('image')
                    ->simpleLightbox(fn ($record) => $record->id % 2 == 0  ? 'https://dummyimage.com/400x400/4144e0/fcfcfc' : 'https://dummyimage.com/400x400/000/fff.png', defaultDisplayUrl: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title'),
                TextColumn::make('resource')
                    ->simpleLightbox(),
                ColumnGroup::make('PDF', [
                    TextColumn::make('pdf')
                        ->alignCenter()
                        ->label('PDF (defaultDisplayUrl as false and default value as "No PDF")')
                        ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: false)
                        ->default(fn ($record) => $record->id % 2 == 0 ? 'View PDF' : 'No PDF'),
                    TextColumn::make('pdf_2')
                        ->alignCenter()
                        ->label('PDF (defaultDisplayUrl as true) demo')
                        ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: true),
                ])->alignCenter(),
                ImageColumn::make('image')
                    ->simpleLightbox(fn ($record) => $record->id % 2 == 0  ? 'https://dummyimage.com/400x400/4144e0/fcfcfc' : 'https://dummyimage.com/400x400/000/fff.png', defaultDisplayUrl: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProductCategories::route('/'),
        ];
    }
}
