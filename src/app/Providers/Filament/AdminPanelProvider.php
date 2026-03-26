<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Widgets\FilamentCmsInfo;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Callout;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use SolutionForest\FilamentCms\FilamentCmsPlugin;
use SolutionForest\FilamentSimpleLightBox\SimpleLightBoxPlugin;
use SolutionForest\SimpleContactForm\SimpleContactFormPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin(SpatieTranslatablePlugin::make()->defaultLocales(config('filament-cms.locales')))
            ->plugin(FilamentCmsPlugin::make())
            ->plugin(SimpleLightBoxPlugin::make())
            ->plugin(SimpleContactFormPlugin::make()
                ->navigationGroup('Plugins')
                ->navigationLabel('Simple Contact Form')
            )
            ->globalSearch(false)
            ->login(Login::class)
            ->darkMode(true)
            ->sidebarCollapsibleOnDesktop(true)
            ->sidebarWidth('17rem')
            ->subNavigationPosition(\Filament\Pages\Enums\SubNavigationPosition::Top)
            ->colors([
                'primary' => [
                    50 => 'oklch(0.9535859816415481 0.03130588051648325 222.04905362663223)',
                    100 => 'oklch(0.8863105551093825 0.08576460744037637 217.49581653477728)',
                    200 => 'oklch(0.7830046395078504 0.1377613364905063 214.18199657343473)',
                    300 => 'oklch(0.6965155632839829 0.12268559281570707 214.41817346035484)',
                    400 => 'oklch(0.6161393961006539 0.10851927500362057 214.40184051490047)',
                    500 => 'oklch(0.5391704937032142 0.09483093761727415 214.1155319631821)',
                    600 => 'oklch(0.48510869892711816 0.08510115434095734 213.56422722104105)',
                    700 => 'oklch(0.4071486679163539 0.07204018913506141 215.30747413765823)',
                    800 => 'oklch(0.3207291331689677 0.05668188123570538 215.07857757399026)',
                    900 => 'oklch(0.22794011507993647 0.040186740694370275 214.60401891564754)',
                    950 => 'oklch(0.17532759303067164 0.030392295499926066 210.65764703957421)',
                ]
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->pages([
                \Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->maxContentWidth(Width::Full)
            ->renderHook(
                PanelsRenderHook::PAGE_START,
                function () {
                    $refCallout = (new Callout('The database will reset every hour.'))->warning();
                    return Blade::render(<<<'BLADE'
                    <x-filament::callout :heading="$heading" :icon="$icon" :color="$color" style="margin-top: 0.75rem;" />
                    BLADE, [
                        'heading' => $refCallout->getHeading(),
                        'icon' => $refCallout->getIcon(),
                        'color' => $refCallout->getColor(),
                    ]);
                }
            )
            ->renderHook(
                PanelsRenderHook::PAGE_HEADER_ACTIONS_AFTER,
                function () {
                    $action = Action::make('preview')
                        ->color('gray')
                        ->url(function () {
                            try {
                                $id = request()->route('record');
                                if (empty($id) || !is_numeric($id)) {
                                    return null;
                                }
                                return  route('contact-form.display', ['key' => $id]);
                            } catch (\Throwable $e) {
                                //
                            }
                            return null;
                        })
                        ->visible(fn (Action $action) => !empty($action->getUrl()));

                    return $action->toHtmlString();
                },
                [
                    \SolutionForest\SimpleContactForm\Resources\ContactForms\Pages\ViewContactForms::class,
                    \SolutionForest\SimpleContactForm\Resources\ContactForms\Pages\EditContactForms::class,
                ]
            );
            
        $this->registerPluginInfo($panel);

        return $panel;
    }

    private function registerPluginInfo(Panel $panel): Panel
    {
        collect([
            \SolutionForest\SimpleContactForm\Resources\ContactForms\ContactFormResource::class => 'simple-contact-form',
            \App\Filament\Clusters\SimpleLightBoxPlugin\Resources\ProductCategoryResource::class => 'filament-simplelightbox',
            \App\Filament\Clusters\TreePlugin\Resources\ProductCategoryResource\Pages\ListProductCategories::class => 'filament-tree',
            \App\Filament\Clusters\TabPlugin\Resources\ProductCategories\ProductCategoryResource::class => 'tab-layout-plugin',
        ])->each(function ($pluginSlug, $resourceOrPage) use ($panel) {
            try {
                $page = null;
                
                if (is_subclass_of($resourceOrPage, Resource::class)) {
                    $page = collect($resourceOrPage::getPages())
                        ->map(fn ($pageClass) => $pageClass instanceof PageRegistration ? $pageClass->getPage() : $pageClass)
                        ->where(fn ($class) => is_string($class) && !empty($class))
                        ->values()
                        ->all();

                    } elseif (is_subclass_of($resourceOrPage, \Filament\Resources\Pages\Page::class)) {
                    $page = $resourceOrPage;
                }

                $ref = new FilamentCmsInfo();
                $ref->limit = [$pluginSlug];
                $info = $ref->getPluginInfos()[0] ?? null;

                if ($page && $info) {
                    $panel
                        ->renderHook(
                            PanelsRenderHook::PAGE_START,
                            fn () => Blade::render(<<<'BLADE'
                            <x-filament::section style="margin-top: 0.75rem;">
                                <a href="{{ $pluginUrl }}" target="_blank" class="mt-2">
                                    <span class="text-sm mr-2">
                                        {{ $name }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $version }}
                                    </span>
                                </a>
                            </x-filament::section>
                            BLADE, [
                                'pluginUrl' => data_get($info, 'url'),
                                'name' => data_get($info, 'name'),
                                'version' => data_get($info, 'version'),
                            ]),
                            $page,
                        );
                }
            } catch (\Throwable $th) {
                // do nothing
            }
        });
        return $panel;
    }
}
