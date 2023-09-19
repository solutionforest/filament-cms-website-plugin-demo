<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsPageResource\Pages;
use App\Models\CmsPage;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Table;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource as BaseResource;

class CmsPageResource extends BaseResource implements 
    HasShieldPermissions // permission shield
{
    use Translatable;

    protected static ?string $model = CmsPage::class;

    public static function getPermissionPrefixes(): array
    {
        return Utils::getGeneralResourcePermissionPrefixes();
        return array_merge(Utils::getGeneralResourcePermissionPrefixes(), [
            'audit',
            'audit_rollback',
            'publish',
            'unpublish',
            'schedule_publish',
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsPages::route('/'),
            'create' => Pages\CreateCmsPage::route('/create'),
            'edit' => Pages\EditCmsPage::route('/{record}/edit'),
        ];
    }    

    public static function table(Table $table): Table
    {
        return parent::table($table)
            // avoid edit docs
            ->checkIfRecordIsSelectableUsing(fn (CmsPage $record) => ! $record->isDocumentPage());
    }
}
