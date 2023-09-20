<?php

namespace App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;

use App\Filament\Resources\CmsPageNavigationCategoryResource;
use App\Filament\Resources\Shield\RoleResource;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
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
