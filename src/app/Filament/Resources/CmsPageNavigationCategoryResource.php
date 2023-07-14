<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsPageNavigationCategoryResource\Pages;
use App\Filament\Resources\CmsPageNavigationCategoryResource\RelationManagers;
use App\Models\CmsPageNavigationCategory;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageNavigationCategoryResource as BaseResource;

class CmsPageNavigationCategoryResource extends BaseResource
{
    use Translatable;
    protected static ?string $model = CmsPageNavigationCategory::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsPageNavigationCategories::route('/'),
            'create' => Pages\CreateCmsPageNavigationCategory::route('/create'),
            'view' => Pages\ViewCmsPageNavigationCategory::route('/{record}'),
            'navigations' => Pages\EditCmsPageNavigation::route('/{category}/navigations'),
        ];
    }    
}
