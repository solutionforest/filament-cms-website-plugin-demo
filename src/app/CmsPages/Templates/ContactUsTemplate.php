<?php

namespace App\CmsPages\Templates;

use Filament\Forms;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Renderer\AtomicDesignPageRenderer;

final class ContactUsTemplate implements CmsPageTemplate
{
    protected static ?string $view = null;

    public static function title(): string
    {
        return 'ContactUsTemplate';
    }

    public static function schema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
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
