<?php

namespace App\Filament\Widgets;

use App\Models\ProductCategory;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Js;
use Livewire\Attributes\On;
use SolutionForest\FilamentNestableTree\Filament\Widgets\Tree as BaseTree;
use SolutionForest\FilamentNestableTree\Tree;

class ProductCategoryNestableTree extends BaseTree
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';


    public function tree(Tree $tree): Tree
    {
        return $tree
            ->labelField('title')
            ->records(fn () => $this->buildModelTree(ProductCategory::orderBy('order')->get()))
            ->searchable()
            ->appendToolbarActions([
                Action::make('intro')
                    ->label('I am Nestable Tree')
                    ->actionJs(<<<'JS'
                        alert('Hello world')
                    JS)
                    ->link()
                    ->extraAttributes(['style' => 'margin-left: auto'])
            ])
            ->saveOrderUsing(function (array $nodes) {
                $this->saveModelTreeOrder($nodes);
                $this->dispatch('refreshTree'); // Tell ProductCategoryTree.php update
            });
    }

    #[On('refreshTree')]
    public function refreshFromOldTree()
    {
        $this->dispatch('tree-refresh');
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
