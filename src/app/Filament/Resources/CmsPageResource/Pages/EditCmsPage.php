<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource\Pages\EditCmsPage as BasePage;

class EditCmsPage extends BasePage
{
    use Translatable;
    protected static string $resource = CmsPageResource::class;
    
    public function getActions(): array
    {
        return array_merge(
            [LocaleSwitcher::make()],
            parent::getActions(),
        );
    }
}
