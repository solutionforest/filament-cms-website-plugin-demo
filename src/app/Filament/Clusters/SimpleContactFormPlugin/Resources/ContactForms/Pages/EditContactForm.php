<?php

namespace App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages;

use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\ContactFormResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactForm extends \SolutionForest\SimpleContactForm\Resources\ContactForms\Pages\EditContactForms
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ActionGroup::make([
                Action::make('viewOnBackend')
                    ->color('info')
                    ->url(fn ($record) => static::getResource()::getUrl('preview', ['record' => $record])),
                Action::make('viewOnFrontend')
                    ->color('gray')
                    ->url(fn ($record) => route('contact-form.display', ['key' => $record->id]), true)
            ])->label('View')->button()->color('gray')->iconPosition('after'),
        ];
    }
}
