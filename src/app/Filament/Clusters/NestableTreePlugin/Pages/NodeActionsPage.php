<?php

namespace App\Filament\Clusters\NestableTreePlugin\Pages;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentNestableTree\Filament\Pages\TreePage;
use SolutionForest\FilamentNestableTree\Tree;

class NodeActionsPage extends TreePage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $cluster = NestableTreePluginCluster::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $title = '2. Node Actions';

    public function tree(Tree $tree): Tree
    {
        return $tree
            ->model(Category::class)
            ->labelField('title')
            ->appendToolbarActions([
                CreateAction::make('create_node')
                    ->model(Category::class)
                    ->schema([TextInput::make('title')->required()])
                    ->after(fn ($livewire) => $livewire->dispatch('tree-refresh'))
                    ->extraAttributes(['style' => 'margin-left: auto']),
            ])
            ->nodeActions(fn (Tree $tree) => [
                EditAction::make('rename')
                    ->iconButton()
                    ->icon('heroicon-o-pencil')
                    ->size('sm')    
                    ->schema([TextInput::make('title')->required()])
                    ->fillForm(fn ($record): array => is_array($record) ? $record : $record->toArray())
                    ->action(function (array $data, $record): void {
                        if (is_object($record)) {
                            $record->update($data);
                        }
                    })
                    ->after(fn ($livewire) => $livewire->dispatch('tree-refresh')),

                DeleteAction::make('delete_node')
                    ->iconButton()
                    ->icon('heroicon-o-trash')
                    ->size('sm')
                    ->after(fn ($livewire) => $livewire->dispatch('tree-refresh')),
            ]);
    }
}
