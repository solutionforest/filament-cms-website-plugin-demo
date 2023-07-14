<?php

namespace App\Filament\Resources\ContentType\BlogResource\Pages;

use Filament\Resources\Pages\ListRecords;
use SolutionForest\FilamentCms\Concern;
use SolutionForest\FilamentCms\Support\Utils;
use App\Filament\Resources\ContentType\BlogResource;

class ListBlogs extends ListRecords
{
    use ListRecords\Concerns\Translatable;

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
        return array_merge(
            [$this->getActiveLocaleSelectAction()],
            parent::getActions(),
        );
    }
}
