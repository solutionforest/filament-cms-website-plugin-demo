<?php

namespace App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;

use App\Filament\Resources\CmsPageNavigationCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageNavigationCategoryResource\Pages\CreateCmsPageNavigationCategory as BasePage;

class CreateCmsPageNavigationCategory extends BasePage
{
    protected static string $resource = CmsPageNavigationCategoryResource::class;
}
