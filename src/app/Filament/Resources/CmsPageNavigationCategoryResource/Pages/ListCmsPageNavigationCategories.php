<?php

namespace App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;

use App\Filament\Resources\CmsPageNavigationCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageNavigationCategoryResource\Pages\ListCmsPageNavigationCategories as BasePage;

class ListCmsPageNavigationCategories extends BasePage
{
    protected static string $resource = CmsPageNavigationCategoryResource::class;
}
