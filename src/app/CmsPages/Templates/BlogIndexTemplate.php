<?php

namespace App\CmsPages\Templates;

use Filament\Forms;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Renderer\AtomicDesignPageRenderer;

final class BlogIndexTemplate implements CmsPageTemplate
{
    protected static ?string $view = null;

    public static function title(): string
    {
        return 'BlogIndexTemplate';
    }

    public static function schema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                Forms\Components\TextInput::make('title')
                        ->label('Title'),
                    Forms\Components\TextInput::make('content')
                        ->label(__('filament-cms::filament-cms.fields.cms_page.block-template.content'))
                ]),
        ];
    }

    public static function getRenderer(): ?string
    {
        return static::$view ?? AtomicDesignPageRenderer::class;
    }

    public static function hiddenOnTemplateOptions(): bool
    {
        return false;
    }
}
