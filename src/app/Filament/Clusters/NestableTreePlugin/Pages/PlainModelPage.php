<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\ProductCategory;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Illuminate\Support\Collection;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class PlainModelPage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 8;

    protected static ?string $title = '8. Plain Model (no NodeTrait)';

    public function tree(Tree $tree): Tree
    {
        return $tree
            ->labelField('title')
            ->records(fn () => $this->buildModelTree(ProductCategory::orderBy('order')->get()))
            ->saveOrderUsing(fn (array $nodes) => $this->saveModelTreeOrder($nodes));
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function buildModelTree(Collection $items, mixed $parentId = -1): array
    {
        return $items
            ->where('parent_id', $parentId)
            ->map(fn (ProductCategory $item) => array_merge($item->toArray(), [
                'children' => $this->buildModelTree($items, $item->id),
            ]))
            ->values()
            ->toArray();
    }
    
    private function saveModelTreeOrder(array $nodes, ?int $parentId = -1, int $startOrder = 0): void
    {
        foreach ($nodes as $index => $node) {
            ProductCategory::where('id', $node['id'])->update([
                'parent_id' => $parentId,
                'order' => $startOrder + $index,
            ]);

            if (! empty($node['children'])) {
                $this->saveModelTreeOrder($node['children'], (int) $node['id'], 0);
            }
        }
    }
}
