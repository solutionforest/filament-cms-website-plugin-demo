<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\ViewProfile;
use App\Filament\Resources\Shield\RoleResource;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
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
            ->plugin(FilamentShieldPlugin::make())
            ->plugin(SimpleLightBoxPlugin::make())
            ->plugin(SimpleContactFormPlugin::make())
            ->globalSearch(false)
            ->login(Login::class)
            ->darkMode(true)
            ->sidebarFullyCollapsibleOnDesktop()
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
            ->profile(ViewProfile::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ->viteTheme('resources/css/filament/admin/theme.css');

        $this->renderHooks($panel);

        return $panel;
    }

    private function renderHooks(Panel $panel)
    {
        $panel->renderHook(
            'panels::page.start',
            fn () => view('alert', [
                'message' => 'The database will reset every hour.',
                'type' => 'warning',
            ])
        );
        $panel->renderHook(
            'panels::page.start',
            fn () => view('alert', [
                'message' => 'Some fields are disabled for guest users.',
                'type' => 'info',
            ]),
            [RoleResource::class],
        );
    }
}
