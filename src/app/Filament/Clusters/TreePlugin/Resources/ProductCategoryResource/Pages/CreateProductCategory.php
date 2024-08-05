<?php

namespace App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages;

use App\Filament\Clusters\TreePlugin\ProductCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductCategory extends CreateRecord
{
    protected static string $resource = ProductCategoryResource::class;
}
