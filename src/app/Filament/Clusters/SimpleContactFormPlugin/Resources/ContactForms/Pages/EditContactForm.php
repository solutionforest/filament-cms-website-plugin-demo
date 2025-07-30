<?php

namespace App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages;

use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\ContactFormResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactForm extends \SolutionForest\SimpleContactForm\Resources\ContactForms\Pages\EditContactForms
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('preview')
                ->color('info')
                ->url(fn ($record) => static::getResource()::getUrl('preview', ['record' => $record])),
        ];
    }
}
