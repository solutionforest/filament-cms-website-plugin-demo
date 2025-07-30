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
            ->globalSearch(false)
            ->login(Login::class)
            ->darkMode(true)
            ->sidebarFullyCollapsibleOnDesktop()
            ->colors([
                'primary' => '#007C90',
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
