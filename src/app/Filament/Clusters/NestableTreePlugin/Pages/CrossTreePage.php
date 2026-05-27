<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\Category;
use App\Models\Tag;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class CrossTreePage extends TreePage
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $title = '6. Cross-Tree Drag';

    protected $listeners = ['tree-cross-move' => 'handleCrossTreeMove'];

    public function trees(): array
    {
        $electronicsId = Category::where('title', 'Electronics')->value('id');
        $clothingId    = Category::where('title', 'Clothing')->value('id');

        $createAction = fn (string $category) => CreateAction::make('create_' . $category)
            ->iconButton()
            ->icon('heroicon-o-plus')
            ->after(fn ($livewire) => $livewire->dispatch('tree-refresh'))
            ->extraAttributes(['style' => 'margin-left: auto'])
            ->schema([
                TextInput::make('name')->required(),
            ])
            ->model(Tag::class)
            ->action(function (array $data, ?string $model) use ($category, $electronicsId, $clothingId): void {
                $categoryId = match ($category) {
                    'technology' => $electronicsId,
                    'science'    => $clothingId,
                    default       => null,
                };

                $model ??= Tag::class;
                $model::create([
                    'name' => $data['name'],
                    'category_id' => $categoryId,
                ]);
            });

        return [
            'technology' => Tree::make()
                ->records(fn () => Tag::where('category_id', $electronicsId)
                    ->defaultOrder()->get()->toTree()->toArray())
                ->labelField('name')
                ->allowCrossCategory()
                ->saveOrderUsing(fn (array $nodes) => Tag::rebuildTree($nodes))
                ->appendToolbarActions([$createAction('technology')]),

            'science' => Tree::make()
                ->records(fn () => Tag::where('category_id', $clothingId)
                    ->defaultOrder()->get()->toTree()->toArray())
                ->labelField('name')
                ->allowCrossCategory()
                ->saveOrderUsing(fn (array $nodes) => Tag::rebuildTree($nodes))
                ->appendToolbarActions([$createAction('science')]),
        ];
    }

    /** Tree key → Category title mapping. */
    private array $treeCategories = [
        'technology' => 'Electronics',
        'science'    => 'Clothing',
    ];

    public function handleCrossTreeMove(
        string $fromTreeKey,
        string $toTreeKey,
        int|string $nodeId,
        mixed $destinationParentId = null,
    ): void {
        $tag = Tag::find($nodeId);

        if (! $tag) {
            return;
        }

        $newCategoryTitle = $this->treeCategories[$toTreeKey] ?? null;
        $newCategoryId    = $newCategoryTitle
            ? Category::where('title', $newCategoryTitle)->value('id')
            : null;

        if ($destinationParentId) {
            $parent = Tag::find($destinationParentId);
            if ($parent) {
                $tag->appendToNode($parent)->save();
            }
        } else {
            $tag->saveAsRoot();
        }

        if ($newCategoryId) {
            $tag->update(['category_id' => $newCategoryId]);
        }

        Notification::make()
            ->title('Tag moved')
            ->body("\"{$tag->name}\" moved from [{$fromTreeKey}] → [{$toTreeKey}]")
            ->success()
            ->send();

        $this->dispatch('tree-refresh');
    }
}
