<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource\Pages\ListCmsPages as BasePage;

class ListCmsPages extends BasePage
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = CmsPageResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
