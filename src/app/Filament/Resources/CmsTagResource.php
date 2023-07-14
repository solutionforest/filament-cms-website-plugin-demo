<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsTagResource\Pages;
use App\Filament\Resources\CmsTagResource\RelationManagers;
use App\Models\CmsTag;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SolutionForest\FilamentCms\Filament\Resources\CmsTagResource as BaseResource;

class CmsTagResource extends BaseResource
{
    use Translatable;

    protected static ?string $model = CmsTag::class;
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsTags::route('/'),
            'create' => Pages\CreateCmsTag::route('/create'),
            'edit' => Pages\EditCmsTag::route('/{record}/edit'),
        ];
    }
}
