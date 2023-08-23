<?php

namespace App\CmsPages\Templates;

use Filament\Forms;
use SolutionForest\FilamentCms\CmsPages\Contracts\CmsPageTemplate;
use SolutionForest\FilamentCms\CmsPages\Renderer\AtomicDesignPageRenderer;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
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
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('title1')->label("Title"),
                    Forms\Components\TextInput::make('subtitle')->label("Sub Title"),
                    Forms\Components\TextInput::make('button_text')->label("Button Text"),
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
                    Forms\Components\Card::make()
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
