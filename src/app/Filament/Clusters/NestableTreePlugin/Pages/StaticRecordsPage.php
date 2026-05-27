<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class StaticRecordsPage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $title = '4. Static Records (JSON)';

    // ── JSON helpers ──────────────────────────────────────────────────────────

    public static function jsonPath(): string
    {
        return storage_path('app/demo/navigation.json');
    }

    public static function readNodes(): array
    {
        $path = static::jsonPath();

        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);

            if (is_array($data)) {
                return $data;
            }
        }
        
        Notification::make()->title('Missing node file')->danger()->send();

        return [];
    }

    public static function writeNodes(array $flat): void
    {
        // $dir = dirname(static::jsonPath());

        // if (! is_dir($dir)) {
        //     mkdir($dir, 0755, true);
        // }

        // file_put_contents(static::jsonPath(), json_encode($flat, JSON_PRETTY_PRINT) . PHP_EOL);
    }

    // ── Tree ──────────────────────────────────────────────────────────────────

    public function tree(Tree $tree): Tree
    {
        return $tree
            ->labelField('title')
            ->records(fn () => static::asTree(static::readNodes()))
            ->saveOrderUsing(function (array $nodes): void {
                // static::writeNodes(static::asFlatten($nodes));
                $sored = static::asFlatten($nodes);
                Notification::make()->title('Readonly')->body(
                    'The sorted nodes:' . json_encode($sored)
                )->send();
            })
            ->appendToolbarActions([
                Action::make('add_node')
                    ->label('Add Node')
                    ->icon('heroicon-o-plus')
                    ->schema([TextInput::make('title')->required()])
                    ->action(function (array $data): void {
                        // $flat   = static::readNodes();
                        // $ids    = array_column($flat, 'id');
                        // $nextId = $ids !== [] ? (int) max($ids) + 1 : 1;
                        // $flat[] = ['id' => $nextId, 'parent_id' => null, 'title' => $data['title']];
                        // static::writeNodes($flat);
                        Notification::make()->title('Readonly')->body('Additional node data:' . json_encode($data))->send();
                    })
                    ->after(fn ($livewire) => $livewire->dispatch('tree-refresh'))
                    ->extraAttributes(['style' => 'margin-left: auto']),
            ]);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Convert a flat parent_id array into a nested tree structure.
     *
     * @param  array<int, array<string, mixed>>  $flat
     * @return array<int, array<string, mixed>>
     */
    public static function asTree(array $flat): array
    {
        $map = [];

        foreach ($flat as $item) {
            $map[$item['id']] = $item + ['children' => []];
        }

        $tree = [];

        foreach ($map as $id => &$node) {
            if ($node['parent_id'] === null || ! isset($map[$node['parent_id']])) {
                $tree[] = &$node;
            } else {
                $map[$node['parent_id']]['children'][] = &$node;
            }
        }

        return $tree;
    }

    /**
     * Flatten a nested tree back to a flat parent_id array.
     *
     * @param  array<int, array<string, mixed>>  $nodes
     * @return array<int, array<string, mixed>>
     */
    public static function asFlatten(array $nodes, mixed $parentId = null): array
    {
        $flat = [];

        foreach ($nodes as $node) {
            $children = $node['children'] ?? [];
            unset($node['children']);
            $node['parent_id'] = $parentId;
            $flat[]            = $node;

            if (! empty($children)) {
                $flat = array_merge($flat, static::asFlatten($children, $node['id']));
            }
        }

        return $flat;
    }
}
