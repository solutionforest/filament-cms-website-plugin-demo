<?php

namespace App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource;

class ManageProductCategories extends ManageRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\FilamentCmsInfo::make(['limit' => ['filament-simplelightbox'], 'showDemoLink' => false]),
        ];
    }
}
