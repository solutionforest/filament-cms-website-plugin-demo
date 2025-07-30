<?php

namespace App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\Pages;

use App\Filament\Clusters\SimpleContactFormPlugin\Resources\ContactForms\ContactFormResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactForm extends \SolutionForest\SimpleContactForm\Resources\ContactForms\Pages\CreateContactForms
{
    protected static string $resource = ContactFormResource::class;
}
