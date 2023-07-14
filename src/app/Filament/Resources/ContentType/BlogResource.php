<?php

namespace App\Filament\Resources\ContentType;

use App\Filament\Resources\ContentType\BlogResource\Pages;
use App\CmsPages\Templates\ContentType\Blog as Template;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentCms\Enums\PageType;
use SolutionForest\FilamentCms\Filament\Resources\ContentTypePageBaseResource as BaseResource;

class BlogResource extends BaseResource
{
    use \Filament\Resources\Concerns\Translatable;

    protected static ?int $navigationSort = null;

    protected static $parentPageKey = '10';

    protected static string $subSlug = 'blogs';

    public static function getModelLabel(): string
    {
        return 'Blog';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'edit' => Pages\EditBlog::route('/{record:id}/edit'),
            'create' => Pages\CreateBlog::route('/create'),
        ];
    }

    public static function getTemplate(): string
    {
        return Template::class;
    }
}
