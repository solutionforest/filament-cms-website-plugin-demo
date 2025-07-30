<?php

namespace App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages;

use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\ContactFormResource;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\Page;

class PreviewContactForm extends EditContactForm
{
    protected static string $resource = ContactFormResource::class;

    protected string $view = 'filament.clusters.simple-contact-form-plugin.resources.contact-forms.pages.preview-form';

    protected static ?string $title = 'Preview Contact Form';

    protected static ?string $breadcrumb = 'Preview';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            ViewAction::make(),
        ];
    }
}
