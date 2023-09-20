<?php

namespace App\CmsPages\Templates\ContentType;

use Filament\Forms;
use Illuminate\Support\Str;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Templates\ContentTypeTemplate as BaseTemplate;

class Document extends BaseTemplate implements CmsPageTemplate
{
    public static function schema(): array
    {
        return [
            Forms\Components\Card::make([
                Forms\Components\TextInput::make('plugin_url')->url(),
                Forms\Components\Repeater::make('sections')
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                $set('section_id', Str::snake($state));
                            })->required(),
                        Forms\Components\TextInput::make('section_id')->required(),
                        Forms\Components\RichEditor::make('content')->required(),
                    ]),
            ])
        ];
    }

    public static function title(): string
    {
        return 'Document';
    }
}
