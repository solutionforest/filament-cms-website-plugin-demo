<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (env('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Livewire\Livewire::component('code-wrapper', \App\Http\Livewire\CodeWrapper::class);

        // // permissions
        // \BezhanSalleh\FilamentShield\Facades\FilamentShield::configurePermissionIdentifierUsing(
        //     fn ($resource) => (string) str($resource::getModel())
        //         ->afterLast('\\')
        //         ->lower()
        // );

        // dd(get_class_methods(CmsPageBaseResource::class));
        // CmsPageBaseResource::bind('dynamicMacroCall', function ($action, $record) {
        //     dd($action, $record);
        // });

        // \SolutionForest\FilamentCms\Filament\Resources\CmsPageBaseResource::macro('can', function () {
        //     dd($this);
        // });

    }
}
