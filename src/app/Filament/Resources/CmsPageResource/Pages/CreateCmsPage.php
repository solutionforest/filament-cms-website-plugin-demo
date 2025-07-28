<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource\Pages\CreateCmsPage as BasePage;

class CreateCmsPage extends BasePage
{
    use Translatable;
    protected static string $resource = CmsPageResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
