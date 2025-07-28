<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use Filament\Actions\CreateAction;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageResource\Pages\ListCmsPages as BasePage;

class ListCmsPages extends BasePage
{
    use Translatable;
    protected static string $resource = CmsPageResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
