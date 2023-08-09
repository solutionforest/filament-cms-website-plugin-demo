<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use Filament\Pages\Actions;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\EditRecord;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource\Pages\EditCmsPage as BasePage;

class EditCmsPage extends BasePage
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = CmsPageResource::class;
    
    public function getActions(): array
    {
        return array_merge(
            [LocaleSwitcher::make()],
            parent::getActions(),
        );
    }
}
