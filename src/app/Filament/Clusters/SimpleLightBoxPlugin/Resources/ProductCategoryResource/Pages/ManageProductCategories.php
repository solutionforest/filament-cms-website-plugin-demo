<?php

namespace App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Support\Enums\Width;
use App\Filament\Widgets\FilamentCmsInfo;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource;

class ManageProductCategories extends ManageRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FilamentCmsInfo::make(['limit' => ['filament-simplelightbox'], 'showDemoLink' => false]),
        ];
    }
}
