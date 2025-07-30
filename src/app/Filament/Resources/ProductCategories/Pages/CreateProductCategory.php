<?php

namespace App\Filament\Resources\ProductCategories\Pages;

use App\Filament\Resources\ProductCategories\ProductCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductCategory extends CreateRecord
{
    protected static string $resource = ProductCategoryResource::class;
}
