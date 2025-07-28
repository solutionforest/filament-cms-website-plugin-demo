<?php

namespace App\Filament\Resources\DataType\LinkResource\Pages;

use App\Filament\Resources\DataType\LinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use SolutionForest\FilamentCms\Concern;
use SolutionForest\FilamentCms\Support\Utils;

class ListLinks extends ListRecords
{
    use Translatable;

    protected static string $resource = LinkResource::class;

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
