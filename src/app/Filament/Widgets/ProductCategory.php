<?php

namespace App\Filament\Widgets;

use App\Models\ProductCategory as ModelsProductCategory;
use App\Filament\Widgets;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class ProductCategory extends BaseWidget
{
    protected static string $model = ModelsProductCategory::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'ProductCategory';

    protected bool $enableTreeTitle = true;

    protected function hasDeleteAction(): bool
    {
        return true;
    }
}
