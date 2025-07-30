<?php

namespace App\Filament\Resources\ProductCategories\Pages;

use App\Filament\Resources\ProductCategories\ProductCategoryResource;
use Filament\Resources\Pages\ListRecords;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;
}
