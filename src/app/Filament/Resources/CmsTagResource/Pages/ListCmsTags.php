<?php

namespace App\Filament\Resources\CmsTagResource\Pages;

use App\Filament\Resources\CmsTagResource;
use Filament\Actions\CreateAction;
use Filament\Pages\Actions;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsTagResource\Pages\ListTags as BasePage;

class ListCmsTags extends BasePage
{
    use Translatable;
    protected static string $resource = CmsTagResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
