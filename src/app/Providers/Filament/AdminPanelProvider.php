<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\Shield\RoleResource;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use SolutionForest\FilamentCms\Filament\Resources\CmsPageBaseResource;
use SolutionForest\FilamentCms\FilamentCmsPanel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin(SpatieLaravelTranslatablePlugin::make()->defaultLocales(config('filament-cms.locales')))
            ->plugin(FilamentCmsPanel::make())
            ->plugin(FilamentShieldPlugin::make())
            ->login(Login::class)
            ->darkMode(true)
            ->sidebarFullyCollapsibleOnDesktop()
            ->colors([
                'primary' => '#007C90',
            ])
            ->profile(\App\Filament\Pages\Auth\ViewProfile::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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

        $this->renderHook($panel);

        return $panel;
    }

    private function renderHook(Panel $panel)
    {
        $panel->renderHook(
            'panels::page.start',
            fn () => view('shout::components.shout', [
                'slot' => 'The database will reset every hour.',
                'color' => 'warning',
                'icon' => 'heroicon-o-exclamation-triangle',
                'extraAttributes' => [
                    'class' => 'mt-6',
                ],
            ])
        );
        $panel->renderHook(
            'panels::page.start',
            fn () => view('shout::components.shout', [
                'slot' => 'Some fields are disabled for guest users.',
                'color' => 'info',
                'icon' => 'heroicon-o-information-circle',
                'extraAttributes' => [
                    'class' => 'mt-6',
                ],
            ]),
            [RoleResource::class],
        );
    }
}
