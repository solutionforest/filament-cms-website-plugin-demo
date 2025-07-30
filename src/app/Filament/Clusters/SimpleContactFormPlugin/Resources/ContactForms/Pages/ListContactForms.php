<?php

namespace App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages;

use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\ContactFormResource;
use App\Filament\Widgets\FilamentCmsInfo;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactForms extends \SolutionForest\SimpleContactForm\Resources\ContactForms\Pages\ListContactForms
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FilamentCmsInfo::make(['limit' => ['simple-contact-form'], 'showDemoLink' => false]),
        ];
    }
}
