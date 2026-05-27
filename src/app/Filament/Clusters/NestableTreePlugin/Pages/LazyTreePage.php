<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class LazyTreePage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clock';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 7;

    protected static ?string $title = '7. Lazy / Async';

    public function tree(Tree $tree): Tree
    {
        return $tree
            ->model(Category::class)
            ->labelField('title')
            ->lazy()
            ->asyncChildren(function (int|string $parentId): array {
                return Category::where('parent_id', $parentId)
                    ->get(['id', 'title', 'parent_id'])
                    ->toArray();
            });
    }
}
