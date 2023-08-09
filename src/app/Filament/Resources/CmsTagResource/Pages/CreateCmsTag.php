<?php

namespace App\Filament\Resources\CmsTagResource\Pages;

use App\Filament\Resources\CmsTagResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use SolutionForest\FilamentCms\Filament\Resources\CmsTagResource\Pages\CreateTag as BasePage;

class CreateCmsTag extends BasePage
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = CmsTagResource::class;
    
    public function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
