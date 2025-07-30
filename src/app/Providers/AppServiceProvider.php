<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use App\Http\Livewire\CodeWrapper;
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
            URL::forceScheme( request()->header('X-Forwarded-Proto', 'https') );
        }

        Livewire::component('code-wrapper', CodeWrapper::class);

        Livewire::component('contact-form', \SolutionForest\SimpleContactForm\Livewire\ContactFormComponent::class);

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
