<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Schemas\Components\LivewireContainer;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;

class DummyTabs extends BaseWidget
{
    protected static ?int $sort = 4;
    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Demo')
                ->icon('heroicon-o-bell') 
                ->badge('39')
                ->schema([
                    // Display livewire component
                    LivewireContainer::make(\Filament\Widgets\AccountWidget::class),

                    // Disply raw string
                    'This is a raw string',

                    // Display livewire 
                    app(\App\Livewire\Dummy::class, ['__id' => uniqid() . '-dummy']),
                    

                    // Display livewire with filling data
                    LivewireContainer::make(\App\Filament\Resources\ProductCategories\Pages\ListProductCategories::class)  //TARGET COMPONENT
                        ->data(['tableSearch' => 'dress']),    // TARGET COMPONENT'S DATA
                ]),

            TabLayoutTab::make('Source Code (Tab Plugin)')
                ->schema([
                    // Display html
                    static::codeToHtml($this->tabPluginDemoSourceCode(), 'php'),
                ]),

            TabLayoutTab::make('Source Code (Tree Plugin)')
                ->schema([
                    // Display html
                    static::codeToHtml($this->treePluginDemoSourceCode(), 'php'),
                ]),

            TabLayoutTab::make('Source Code (Nestable Tree Plugin)')
                ->schema([
                    // Display html
                    static::codeToHtml($this->nestableTreePluginDemoSourceCode(), 'php'),
                ]),

            // Hyper link
            TabLayoutTab::make('Go To Filamentphp (Link)')
                ->url("https://filamentphp.com/", true),
        ];
    }

    protected static function codeToHtml(string $code, $grammar = 'php')
    {
        $phiki = new \Phiki\Phiki();
        $lightTheme = \Phiki\Theme\Theme::GithubLight;
        $darkTheme = \Phiki\Theme\Theme::GithubDarkHighContrast;
        $content = (string) $phiki->codeToHtml($code, $grammar, [
            'light' => $lightTheme,
            'dark' => $darkTheme,
        ]);
        return str($content)
            ->wrap('<div class="fi-in-code">', '</div>')
            ->toHtmlString();
    }

    protected function tabPluginDemoSourceCode(): string
    {
        return <<<'EOL'
<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Schemas\Components\LivewireContainer;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabContainer;

class DummyTabs extends BaseWidget
{
    protected function schema(): array
    {
        return [
            TabLayoutTab::make('Demo')
                ->icon('heroicon-o-bell') 
                ->badge('39')
                ->schema([
                    // Display livewire component
                    LivewireContainer::make(\Filament\Widgets\AccountWidget::class),

                    // Disply raw string
                    'This is a raw string',

                    // Display livewire 
                    app(\App\Livewire\Dummy::class, ['__id' => uniqid() . '-dummy']),
                    

                    // Display livewire with filling data
                    LivewireContainer::make(\App\Filament\Resources\ProductCategories\Pages\ListProductCategories::class)  //TARGET COMPONENT
                        ->data(['tableSearch' => 'dress']),    // TARGET COMPONENT'S DATA
                ]),

            TabLayoutTab::make('Source Code (Tab Plugin)')
                ->schema([
                    // Display html
                    static::codeToHtml($this->tabPluginDemoSourceCode(), 'php'),
                ]),

            TabLayoutTab::make('Source Code (Tree Plugin)')
                ->schema([
                    // Display html
                    static::codeToHtml($this->treePluginDemoSourceCode(), 'php'),
                ]),

            // Hyper link
            TabLayoutTab::make('Go To Filamentphp (Link)')
                ->url("https://filamentphp.com/", true),
        ];
    }

    protected static function codeToHtml(string $code, $grammar = 'php')
    {
        $phiki = new \Phiki\Phiki();
        $lightTheme = \Phiki\Theme\Theme::GithubLight;
        $darkTheme = \Phiki\Theme\Theme::GithubDarkHighContrast;
        $content = (string) $phiki->codeToHtml($code, $grammar, [
            'light' => $lightTheme,
            'dark' => $darkTheme,
        ]);
        return str($content)
            ->wrap('<div class="fi-in-code">', '</div>')
            ->toHtmlString();
    }
}
EOL;
    }

    protected function treePluginDemoSourceCode(): string
    {
        $filename = 'ProductCategoryTree.php';
        $path = base_path('app/Filament/Widgets/' . $filename);
        $content = file_get_contents($path);
        return $content ?: '';
    }

    protected function nestableTreePluginDemoSourceCode(): string
    {
        $filename = 'ProductCategoryNestableTree.php';
        $path = base_path('app/Filament/Widgets/' . $filename);
        $content = file_get_contents($path);
        return $content ?: '';
    }
}