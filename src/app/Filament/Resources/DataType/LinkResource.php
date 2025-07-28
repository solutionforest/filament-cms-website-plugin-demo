<?php

namespace App\Filament\Resources\DataType;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use App\Filament\Resources\DataType\LinkResource\Pages\ListLinks;
use App\Filament\Resources\DataType\LinkResource\Pages\EditLink;
use App\Filament\Resources\DataType\LinkResource\Pages\CreateLink;
use App\Filament\Resources\DataType\LinkResource\Pages;
use App\CmsPages\Templates\DataType\Link as Template;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentCms\Enums\PageType;
use SolutionForest\FilamentCms\Filament\Resources\DataTypePageBaseResource as BaseResource;

class LinkResource extends BaseResource
{
    use Translatable;

    protected static ?int $navigationSort = null;

    protected static $parentPageKey = '5';

    protected static string $subSlug = 'link';

    public static function getModelLabel(): string
    {
        return 'Link';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLinks::route('/'),
            'edit' => EditLink::route('/{record:id}/edit'),
            'create' => CreateLink::route('/create'),
        ];
    }

    public static function getTemplate(): string
    {
        return Template::class;
    }
}
