<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class BasicTreePage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-folder';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $title = '1. Basic Tree';

    public function tree(Tree $tree): Tree
    {
        return $tree
            ->model(Category::class)
            ->labelField('title');
    }
}
