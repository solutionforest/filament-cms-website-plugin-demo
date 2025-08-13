<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsPageResource\Pages\ListCmsPages;
use App\Filament\Resources\CmsPageResource\Pages\CreateCmsPage;
use App\Filament\Resources\CmsPageResource\Pages\EditCmsPage;
use App\Filament\Resources\CmsPageResource\Pages;
use App\Models\CmsPage;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource as BaseResource;

class CmsPageResource extends BaseResource implements 
    HasShieldPermissions // permission shield
{
    use Translatable;

    protected static ?string $model = CmsPage::class;

    public static function getPermissionPrefixes(): array
    {
        return Utils::getGeneralResourcePermissionPrefixes(static::class);
        // return array_merge(Utils::getGeneralResourcePermissionPrefixes(), [
        //     'audit',
        //     'audit_rollback',
        //     'publish',
        //     'unpublish',
        //     'schedule_publish',
        // ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsPages::route('/'),
            'create' => CreateCmsPage::route('/create'),
            'edit' => EditCmsPage::route('/{record}/edit'),
        ];
    }    

    public static function table(Table $table): Table
    {
        return parent::table($table)
            // avoid edit docs
            ->checkIfRecordIsSelectableUsing(fn (CmsPage $record) => ! $record->isDocumentPage());
    }
}
