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
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Filament\Tables;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageNavigationCategoryResource as BaseResource;

class CmsPageNavigationCategoryResource extends BaseResource
{
    use Translatable;

    protected static ?string $model = CmsPageNavigationCategory::class;

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
}
