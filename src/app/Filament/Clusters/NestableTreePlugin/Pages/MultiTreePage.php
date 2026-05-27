<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\Category;
use App\Models\Tag;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class MultiTreePage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $title = '5. Multiple Trees';

    public function trees(): array
    {
        return [
            'categories' => Tree::make()
                ->model(Category::class)
                ->labelField('title')
                ->searchable(),

            'tags' => Tree::make()
                ->model(Tag::class)
                ->labelField('name')
                ->searchable(),
        ];
    }
}
