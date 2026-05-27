<?php

namespace App\Filament\Tabs\Components;

use App\Filament\Widgets\ProductCategoryTree as ComponentTabComponent;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabLayoutComponent;

class ProductCategory extends TabLayoutComponent
{
    protected ?string $component = ComponentTabComponent::class;
}
