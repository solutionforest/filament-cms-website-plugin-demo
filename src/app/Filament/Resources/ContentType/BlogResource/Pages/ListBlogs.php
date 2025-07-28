<?php

namespace App\Filament\Resources\ContentType\BlogResource\Pages;

use App\Filament\Resources\ContentType\BlogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use SolutionForest\FilamentCms\Concern;
use SolutionForest\FilamentCms\Support\Utils;

class ListBlogs extends ListRecords
{
    use Translatable;

    protected static string $resource = BlogResource::class;

    public function isTableSearchable(): bool
    {
        return false;
    }

    public function isTableFilterable(): bool
    {
        return false;
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
