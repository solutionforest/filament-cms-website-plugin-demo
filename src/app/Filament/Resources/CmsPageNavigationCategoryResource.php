<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;
use App\Models\CmsPageNavigationCategory;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables;
use Filament\Tables\Table;
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
            'index' => Pages\ListCmsPageNavigationCategories::route('/'),
            'create' => Pages\CreateCmsPageNavigationCategory::route('/create'),
            'view' => Pages\ViewCmsPageNavigationCategory::route('/{record}'),
            'navigations' => Pages\EditCmsPageNavigation::route('/{category}/navigations'),
        ];
    }    

    public static function table(Table $table): Table
    {
        $table = parent::table($table);
        
        $actions = collect($table->getActions())
            ->map(fn (Tables\Actions\Action $action) => $action->getName() == 'navigations'
                // permission of navigation category 
                // @todo add to plugin
                ? $action->authorize('update_cms::page::navigation::category')
                : $action
            )
            ->toArray();

        return $table->actions($actions);
    }
}
