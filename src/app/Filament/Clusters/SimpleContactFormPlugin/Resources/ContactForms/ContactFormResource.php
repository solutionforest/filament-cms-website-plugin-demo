<?php

namespace App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms;

use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages\CreateContactForm;
use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages\EditContactForm;
use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages\ListContactForms;
use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages\PreviewContactForm;
use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Schemas\ContactFormForm;
use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Tables\ContactFormsTable;
use App\Filament\Clusters\SimpleContactFormPlugin\SimpleContactFormPluginCluster;
use BackedEnum;
use ContactForm;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use SolutionForest\SimpleContactForm\Resources\ContactForms\ContactFormResource as ContactFormsContactFormResource;

class ContactFormResource extends ContactFormsContactFormResource
{
    protected static ?string $cluster = SimpleContactFormPluginCluster::class;

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->actions([
                EditAction::make(),
                Action::make('preview')
                    ->icon(Heroicon::Ticket)
                    ->color('info')
                    ->url(fn ($record) => static::getUrl('preview', ['record' => $record]))
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactForms::route('/'),
            'create' => CreateContactForm::route('/create'),
            'edit' => EditContactForm::route('/{record}/edit'),
            'preview' => PreviewContactForm::route('/{record}/preview'),
        ];
    }
}
