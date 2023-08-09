<?php

namespace App\Filament\Resources\CmsTagResource\Pages;

use App\Filament\Resources\CmsTagResource;
use Filament\Actions\LocaleSwitcher;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use SolutionForest\FilamentCms\Filament\Resources\CmsTagResource\Pages\EditTag as BasePage;

class EditCmsTag extends BasePage
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = CmsTagResource::class;
    
    public function getActions(): array
    {
        return array_merge([
            LocaleSwitcher::make(),
        ], parent::getActions());
    }
}
