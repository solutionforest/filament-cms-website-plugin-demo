<?php

namespace App\Providers\Filament;

use App\Filament\Clusters\NestableTreePlugin\NestableTreePluginCluster;
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
            ...collect($panel->getClusteredComponents(NestableTreePluginCluster::class))
                ->where(fn ($class) => is_subclass_of($class, \Filament\Pages\Page::class))
                ->values()
                ->mapWithKeys(function ($component) {
                    return [$component => 'filament-nestable-tree'];
                })
                ->all(),
        ])->each(function ($pluginSlug, $resourceOrPage) use ($panel) {
            try {
                $page = null;
                
                if (is_subclass_of($resourceOrPage, Resource::class)) {
                    $page = collect($resourceOrPage::getPages())
                        ->map(fn ($pageClass) => $pageClass instanceof PageRegistration ? $pageClass->getPage() : $pageClass)
                        ->where(fn ($class) => is_string($class) && !empty($class))
                        ->values()
                        ->all();

                } elseif (
                    is_subclass_of($resourceOrPage, \Filament\Resources\Pages\Page::class) ||
                    is_subclass_of($resourceOrPage, \Filament\Pages\Page::class)
                ) {
                    $page = $resourceOrPage;
                }

                $ref = new FilamentCmsInfo();
                $ref->limit = [$pluginSlug];
                $info = $ref->getPluginInfos()[0] ?? null;
                if (str($resourceOrPage)->startsWith('App\\') && ($indexPage = collect($page)->first() ?? null)) {
                    $demoSourceCodeUrl = 'https://github.com/solutionforest/filament-cms-website-plugin-demo/tree/main/src/' . str($indexPage)->replace('App\\', 'app\\')->replace('\\', '/')->finish('.php')->toString();
                } else {
                    $demoSourceCodeUrl = null;
                }

                if ($page && $info) {
                    $panel
                        ->renderHook(
                            PanelsRenderHook::PAGE_START,
                            fn () => Blade::render(<<<'BLADE'
                            <x-filament::section style="margin-top: 0.75rem;">
                                <div style="display: flex;justify-content: space-between;">
                                    <a href="{{ $pluginUrl }}" target="_blank">
                                        <span class="text-sm mr-2">
                                            {{ $name }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $version }}
                                        </span>
                                    </a>
                                    @if (filled($demoSourceCodeUrl))
                                        <x-filament::link
                                            color="gray"
                                            href="{{ $demoSourceCodeUrl }}"
                                            icon-alias="panels::widgets.filament-info.open-github-button"
                                            rel="noopener noreferrer"
                                            target="_blank"
                                        >
                                            <x-slot name="icon">
                                                <svg
                                                    viewBox="0 0 98 96"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        clip-rule="evenodd"
                                                        fill="currentColor"
                                                        fill-rule="evenodd"
                                                        d="M48.854 0C21.839 0 0 22 0 49.217c0 21.756 13.993 40.172 33.405 46.69 2.427.49 3.316-1.059 3.316-2.362 0-1.141-.08-5.052-.08-9.127-13.59 2.934-16.42-5.867-16.42-5.867-2.184-5.704-5.42-7.17-5.42-7.17-4.448-3.015.324-3.015.324-3.015 4.934.326 7.523 5.052 7.523 5.052 4.367 7.496 11.404 5.378 14.235 4.074.404-3.178 1.699-5.378 3.074-6.6-10.839-1.141-22.243-5.378-22.243-24.283 0-5.378 1.94-9.778 5.014-13.2-.485-1.222-2.184-6.275.486-13.038 0 0 4.125-1.304 13.426 5.052a46.97 46.97 0 0 1 12.214-1.63c4.125 0 8.33.571 12.213 1.63 9.302-6.356 13.427-5.052 13.427-5.052 2.67 6.763.97 11.816.485 13.038 3.155 3.422 5.015 7.822 5.015 13.2 0 18.905-11.404 23.06-22.324 24.283 1.78 1.548 3.316 4.481 3.316 9.126 0 6.6-.08 11.897-.08 13.526 0 1.304.89 2.853 3.316 2.364 19.412-6.52 33.405-24.935 33.405-46.691C97.707 22 75.788 0 48.854 0z"
                                                    />
                                                </svg>
                                            </x-slot>
                                            Demo Source Code
                                        </x-filament::link>
                                    @endif
                                </div>
                            </x-filament::section>
                            BLADE, [
                                'pluginUrl' => data_get($info, 'url'),
                                'name' => data_get($info, 'name'),
                                'version' => data_get($info, 'version'),
                                'demoSourceCodeUrl' => $demoSourceCodeUrl,
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
