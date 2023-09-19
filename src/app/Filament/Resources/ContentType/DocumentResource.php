<?php

namespace App\Filament\Resources\ContentType;

use App\Filament\Resources\ContentType\DocumentResource\Pages;
use App\CmsPages\Templates\ContentType\Document as Template;
use Filament\Forms;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentCms\Enums\PageType;
use SolutionForest\FilamentCms\Filament\Resources\ContentTypePageBaseResource as BaseResource;

class DocumentResource extends BaseResource
{
    use \Filament\Resources\Concerns\Translatable;

    protected static ?int $navigationSort = null;

    protected static $parentPageKey = '15';

    protected static string $subSlug = 'docs';

    public static function getModelLabel(): string
    {
        return 'Document';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'edit' => Pages\EditDocument::route('/{record:id}/edit'),
            'create' => Pages\CreateDocument::route('/create'),
        ];
    }

    public static function getTemplate(): string
    {
        return Template::class;
    }
}
