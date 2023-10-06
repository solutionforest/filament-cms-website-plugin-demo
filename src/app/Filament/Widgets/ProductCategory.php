<?php

namespace App\Filament\Widgets;

use App\Models\ProductCategory as ModelsProductCategory;
use App\Filament\Widgets;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class ProductCategory extends BaseWidget
{
    protected static string $model = ModelsProductCategory::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'Product Category';

    protected bool $enableTreeTitle = true;

    public static function canView(): bool
    {
        return Filament::auth()->user()->can('widget_ProductCategory');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title'),
        ];
    }

    protected function hasDeleteAction(): bool
    {
        return true;
    }
    protected function hasEditAction(): bool
    {
        return true;
    }

    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        // default null
        if ($record?->getKey() == 1) {

            return 'heroicon-o-shopping-bag';
        }
        return null;
    }
}
