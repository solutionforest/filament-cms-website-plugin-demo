<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages\ListCmsPageNavigationCategories;
use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages\CreateCmsPageNavigationCategory;
use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages\ViewCmsPageNavigationCategory;
use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages\EditCmsPageNavigation;
use Filament\Actions\Action;
use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;
use App\Filament\Resources\Shield\RoleResource;
use App\Models\CmsPageNavigationCategory;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Filament\Tables;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageNavigationCategoryResource as BaseResource;

class CmsPageNavigationCategoryResource extends BaseResource implements 
    HasShieldPermissions // permission shield
{
    use Translatable;
    protected static ?string $model = CmsPageNavigationCategory::class;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'update_navigation',
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsPageNavigationCategories::route('/'),
            'create' => CreateCmsPageNavigationCategory::route('/create'),
            'view' => ViewCmsPageNavigationCategory::route('/{record}'),
            'navigations' => EditCmsPageNavigation::route('/{category}/navigations'),
        ];
    }    

    public static function table(Table $table): Table
    {
        $table = parent::table($table);

        $actions = collect($table->getActions())
            ->map(fn (Action $action) => match($action->getName()) {
                // permission of navigation category 
                // @todo add to plugin
                'navigations' => $action->authorize('update_navigation_cms::page::navigation::category'),
                default => $action,
            })
            ->all();

        return $table->recordActions($actions);
    }

    public static function getPagePermissionName(string $action): string
    {
        return match ($action) {
            'index' => 'view_any_cms::page::navigation::category',
            'create' => 'create_cms::page::navigation::category',
            'view' => 'view_cms::page::navigation::category',
            'navigations' => 'update_navigation_cms::page::navigation::category',
            default => null,
        };
    }

    protected static function getPermissionNames(): array
    {
        $permissionIdentifier = FilamentShield::getPermissionIdentifier(static::class);
        $entity = data_get(FilamentShield::getResources(), $permissionIdentifier, []);
        $allResourcePermissions = array_keys(RoleResource::getResourcePermissionOptions($entity));

        return $allResourcePermissions;
    }
}
