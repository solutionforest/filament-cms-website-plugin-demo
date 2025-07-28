<?php

namespace App\CmsPages\Templates;

use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use Filament\Forms;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Renderer\AtomicDesignPageRenderer;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;

final class HomepageTemplate implements CmsPageTemplate
{
    protected static ?string $view = null;

    public static function title(): string
    {
        return 'HomepageTemplate';
    }

    public static function schema(): array
    {
        return [
            Section::make()
                ->schema([
                    TextInput::make('title1')->label("Title"),
                    TextInput::make('subtitle')->label("Sub Title"),
                    TextInput::make('button_text')->label("Button Text"),
                    TextInput::make('button_link')
                        ->suffixAction(fn (?string $state): Action =>
                            Action::make('visit')
                                ->icon('heroicon-o-link')
                                ->url(
                                    filled($state) ? "https://{$state}" : null,
                                    shouldOpenInNewTab: true,
                                ),
                        ),
                    RichEditor::make('my_story')->label("My Story")
                    ])->label("Section 1"),
                    Section::make()
                    ->schema([
                        
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
