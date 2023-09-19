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
    use HasPageShield {// page permission checking
        HasPageShield::getPermissionName as private traitGetPermissionName;
    } 

    protected static string $resource = CmsPageNavigationCategoryResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            $this->getCreateAction(),
        ];
    }

    protected static function getPermissionName(): string
    {
        $resource = static::getResource();

        $permissionIdentifier = FilamentShield::getPermissionIdentifier($resource);
        $key = "update_navigation_{$permissionIdentifier}";
        $entity = data_get(FilamentShield::getResources(), $permissionIdentifier, []);
        $allResourcePermissions = array_keys(RoleResource::getResourcePermissionOptions($entity));

        if (! empty($allResourcePermissions) && in_array($key, $allResourcePermissions)) {
            return $key;
        }

        return static::traitGetPermissionName();
    }
}
