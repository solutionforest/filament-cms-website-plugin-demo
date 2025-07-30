<?php

namespace App\Filament\Clusters\TreePlugin\Pages;

use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use App\Filament\Widgets\FilamentCmsInfo;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use App\Filament\Clusters\TreePlugin\TreePluginCluster;
use App\Models\CmsPageNavigation as TreePageModel;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use SolutionForest\FilamentCms\Enums\NavigationType;
use SolutionForest\FilamentCms\Enums\PageType;
use SolutionForest\FilamentCms\Enums\UrlTarget;
use SolutionForest\FilamentTree\Concern\TreeRecords\Translatable;
use SolutionForest\FilamentTree\Pages\TreePage as BasePage;
use SolutionForest\FilamentTree\Support\Utils as FilamentTreeHelper;

class MainMenuNavigation extends BasePage
{
    use Translatable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bars-3-center-left';

    protected static ?string $cluster = TreePluginCluster::class;

    protected static ?int $navigationSort = 10;

    protected static string $model = TreePageModel::class;

    protected static int $maxDepth = 10;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            $this->getCreateAction()->modelLabel('Navigation (Main Menu)'),
        ];
    }

    protected function getTreeActions(): array
    {
        return [
            EditAction::make(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FilamentCmsInfo::make(['limit' => ['filament-tree'], 'showDemoLink' => false]),
        ];
    }

    // -- Tree setup --
    public function getTreeRecordTitle(?Model $record = null): string
    {
        if (! $record) {
            return '';
        }

        $category = $record->category?->title;
        $translatedTitle = $record->title; // translated title (setup on model)

        return "[$category] $translatedTitle";
    }
    protected function getSortedQuery(): Builder
    {
        // The query for tree
        return parent::getSortedQuery()->where('category_id', static::mainCategoryId());
    }
    // -- Tree setup --

    // -- Locale setup --
    public function getTranslatableLocales(): array
    {
        return config('filament-spatie-laravel-translatable-plugin.default_locales')
            ?? config('filament-cms.locales')
            ?? [];
    }
    // -- Locale setup --

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            TextInput::make('category_id')->default(static::mainCategoryId())->readOnly()->required(),

            Select::make('parent_id')
                ->label(__('filament-cms::filament-cms.fields.cms_page_navigation.parent'))
                ->options(function ($get, ?Model $record) {
                    $options = static::getParentOptions(static::mainCategoryId());
                    if ($record) {
                        unset($options[$record->getKey()]);
                    }
                    return $options;
                })
                ->default(FilamentTreeHelper::defaultParentId())
                ->required(),

            Select::make('type')
                ->label(__('filament-cms::filament-cms.fields.cms_page_navigation.type'))
                ->reactive()
                ->dehydrated(fn ($context) => $context != 'create')
                ->formatStateUsing(function (?Model $record): ?string {
                    if ($record?->page_id) {
                        return NavigationType::PAGE;
                    }
                    if ($record?->url) {
                        return NavigationType::EXTERNAL;
                    }

                    return null;
                })
                ->options(static::getNavigationTypeOptions()),

            Group::make([
                Select::make('page_id')
                    ->label(__('filament-cms::filament-cms.fields.cms_page_navigation.page'))
                    ->searchable()
                    ->options(static::getPageOptions())
                    ->visible(fn ($get) => static::typeIsPage($get))
                    ->required(fn ($get) => static::typeIsPage($get)),

                TextInput::make('url')
                    ->label(__('filament-cms::filament-cms.fields.cms_page_navigation.url'))
                    ->visible(fn ($get) => static::typeIsExternal($get))
                    ->required(fn ($get) => static::typeIsExternal($get)),

                Select::make('target')
                    ->label(__('filament-cms::filament-cms.fields.cms_page_navigation.target'))
                    ->options(static::getUrlTargetOptions()),

            ])->columns(['default' => 2]),
        ];
    }

    // -- Local used helper functions --
    public static function getPageNavigationModel(): string
    {
        return static::$model;
    }
    public static function getParentOptions(int $categoryKey): Collection
    {
        return collect(static::getPageNavigationModel()::selectArray($categoryKey, static::getMaxDepth() - 1));
    }
    public static function getPageOptions(): Collection
    {
        return \SolutionForest\FilamentCms\Support\Utils::getCmsPageModel()::query()
            ->withOnly([])
            ->whereNot('page_type', PageType::DATA_TYPE)
            ->pluck('title', 'id');
    }
    public static function getNavigationTypeOptions(): Collection
    {
        return collect(NavigationType::asSelectArray());
    }
    public static function getUrlTargetOptions(): Collection
    {
        return collect(UrlTarget::asSelectArray());
    }
    protected static function typeIsPage(callable $get): bool
    {
        return $get('type') === NavigationType::PAGE;
    }
    protected static function typeIsExternal(callable $get)
    {
        return $get('type') === NavigationType::EXTERNAL;
    }
    private static function mainCategoryId(): int
    {
        return 1;
    }
    // -- Local used helper functions --
}
