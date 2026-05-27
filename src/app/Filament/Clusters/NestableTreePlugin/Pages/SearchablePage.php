<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\Category;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class SearchablePage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $title = '3. Searchable';

    public function tree(Tree $tree): Tree
    {
        return $tree
            ->model(Category::class)
            ->labelField('title')
            ->searchable();
    }
}
