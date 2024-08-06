<?php

namespace App\Filament\Clusters\SimpleLightBoxPlugin\Resources;

use App\Filament\Clusters\SimpleLightBoxPlugin;
use App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource\Pages;
use App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schema\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Console\View\Components\Info;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = SimpleLightBoxPlugin::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('resource')->url(),
            ]);
    }

    public static function infolist(Infolist $infolist): InfoList
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('id'),
                Infolists\Components\TextEntry::make('title'),

                Infolists\Components\TextEntry::make('resource')
                    ->simpleLightbox(fn ($record) => $record->resource),

                Infolists\Components\Section::make('PDF')
                    ->aside()
                    ->columnSpanFull()
                    ->schema([
                        Infolists\Components\TextEntry::make('pdf')
                            ->label('PDF (defaultDisplayUrl as false and default value as "No PDF")')
                            ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: false)
                            ->default(fn ($record) => $record->id % 2 == 0 ? 'View PDF' : 'No PDF'),
                        Infolists\Components\TextEntry::make('pdf_2')
                            ->label('PDF (defaultDisplayUrl as true) demo')
                            ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: true),
                    ]),
                Infolists\Components\ImageEntry::make('image')
                    ->simpleLightbox(fn ($record) => $record->id % 2 == 0  ? 'https://dummyimage.com/400x400/4144e0/fcfcfc' : 'https://dummyimage.com/400x400/000/fff.png', defaultDisplayUrl: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('resource')
                    ->simpleLightbox(),
                Tables\Columns\ColumnGroup::make('PDF', [
                    Tables\Columns\TextColumn::make('pdf')
                        ->alignCenter()
                        ->label('PDF (defaultDisplayUrl as false and default value as "No PDF")')
                        ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: false)
                        ->default(fn ($record) => $record->id % 2 == 0 ? 'View PDF' : 'No PDF'),
                    Tables\Columns\TextColumn::make('pdf_2')
                        ->alignCenter()
                        ->label('PDF (defaultDisplayUrl as true) demo')
                        ->simpleLightbox(fn ($record) => $record->id % 2 == 0 ? 'https://tourism.gov.in/sites/default/files/2019-04/dummy-pdf_2.pdf' : 'N/A', defaultDisplayUrl: true),
                ])->alignCenter(),
                Tables\Columns\ImageColumn::make('image')
                    ->simpleLightbox(fn ($record) => $record->id % 2 == 0  ? 'https://dummyimage.com/400x400/4144e0/fcfcfc' : 'https://dummyimage.com/400x400/000/fff.png', defaultDisplayUrl: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ManageProductCategories::route('/'),
        ];
    }
}
