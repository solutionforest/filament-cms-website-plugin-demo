<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource\Pages\CreateCmsPage as BasePage;

class CreateCmsPage extends BasePage
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = CmsPageResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
