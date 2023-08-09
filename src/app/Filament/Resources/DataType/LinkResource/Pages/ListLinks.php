<?php

namespace App\Filament\Resources\DataType\LinkResource\Pages;

use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use SolutionForest\FilamentCms\Concern;
use SolutionForest\FilamentCms\Support\Utils;
use App\Filament\Resources\DataType\LinkResource;
use Filament\Actions\CreateAction;

class ListLinks extends ListRecords
{
    use ListRecords\Concerns\Translatable;

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
