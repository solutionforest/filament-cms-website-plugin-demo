<?php

namespace App\Filament\Resources\CmsTagResource\Pages;

use App\Filament\Resources\CmsTagResource;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use SolutionForest\FilamentCms\Filament\Resources\CmsTagResource\Pages\ListTags as BasePage;

class ListCmsTags extends BasePage
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = CmsTagResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
