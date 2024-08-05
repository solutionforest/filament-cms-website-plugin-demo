<?php

namespace App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages;

use App\Filament\Clusters\TreePlugin\ProductCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductCategory extends EditRecord
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
