<?php

namespace App\Filament\Resources\CmsTagResource\Pages;

use App\Filament\Resources\CmsTagResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use SolutionForest\FilamentCms\Filament\Resources\CmsTagResource\Pages\CreateTag as BasePage;

class CreateCmsTag extends BasePage
{
    use Translatable;
    protected static string $resource = CmsTagResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
