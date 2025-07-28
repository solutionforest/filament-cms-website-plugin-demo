<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Policies\CmsPageNavigationCategoryPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use SolutionForest\FilamentCms\Models\CmsPageNavigationCategory;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CmsPageNavigationCategory::class => CmsPageNavigationCategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            if ($user?->isSuperAdmin() ?? false) {
                return true;
            }
            return null;
        });

        // Gate::define('audit', fn () => false);
        // Gate::define('rollbackAudit', fn () => false);
    }
}
