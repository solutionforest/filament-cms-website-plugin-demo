<?php

namespace App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;

use App\Filament\Resources\CmsPageNavigationCategoryResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageNavigationCategoryResource\Pages\EditCmsPageNavigation as BasePage;

class EditCmsPageNavigation extends BasePage
{
    protected static string $resource = CmsPageNavigationCategoryResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            $this->getCreateAction(),
        ];
    }
}
