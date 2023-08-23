<?php

use App\Filament\Resources\CmsPageNavigationCategoryResource;
use App\Filament\Resources\CmsPageResource;
use App\Filament\Resources\CmsTagResource;
use App\Http\Middleware\Localization;
use App\Models\CmsPage;
use App\Models\CmsPageNavigation;
use App\Models\CmsPublishedPage;
use App\Models\CmsTag;
use App\Models\CmsTagCategory;
use SolutionForest\FilamentCms\CmsPages\Renderer;
use SolutionForest\FilamentCms\CmsPages\Templates;
use SolutionForest\FilamentCms\Filament\Resources;
use SolutionForest\FilamentCms\Http\Middleware;
use SolutionForest\FilamentCms\Models;

return [

    'theme' => 'default',

    'default_layout' => 'app',

    'locales' => [
        'en',
        'zh-HK',
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware for front-end pages
    |
    */
    'middleware' => [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            Localization::class,
        ],
    ],

    'filament' => [
        'resources' => [
            'cms_page' => CmsPageResource::class,
            'cms_page_navigation_category' => CmsPageNavigationCategoryResource::class,
            'cms_tag' => CmsTagResource::class,
        ],
        'navigation' => [
            'icon' => [
                CmsPageResource::class => 'heroicon-o-document',
                CmsPageNavigationCategoryResource::class => 'heroicon-o-bars-3-center-left',
                CmsTagResource::class => 'heroicon-o-tag',
            ],
            'sort' => [
                CmsPageResource::class => -10,
                CmsTagResource::class => -9,
                CmsPageNavigationCategoryResource::class => -8,
            ],
        ],
        'recordTitleAttribute' => [
            'cms_page' => 'title',
            'cms_navigation_category' => 'title',
            'cms_tag' => 'name',
        ],
    ],
    
    'enable_page_tags' => true,
    
    'enable_audit_log' => true,

    'cms_pages' => [

        'include_default_template' => true,

        'templates' => [
            Templates\DefaultTemplate::class,
            Templates\BlockTemplate::class,
        ],

        /**
         * Specific the render for the page template
         */
        'renderers' => [
            /**
             * Default render if no specify
             */
            'default' => Renderer\AtomicDesignPageRenderer::class,
            'namespace' => 'App\\CmsPages\\Renderer',
            'path' => app_path('CmsPages/Renderer'),
        ],

        'navigation' => [
            'main_menu' => [
                'enabled' => true,
                'name' => 'main-menu',
            ],
        ],

        'namespace' => 'App\\CmsPages\\Templates',
        'path' => app_path('CmsPages/Templates'),

    ],

    'models' => [
        'cms_page' => CmsPage::class,
        'cms_published_page' => CmsPublishedPage::class,
        'cms_page_navigation' => CmsPageNavigation::class,
        'cms_page_navigation_category' => Models\CmsPageNavigationCategory::class,
        'cms_tag' => CmsTag::class,
        'cms_taggable' => Models\CmsTaggable::class,
        'cms_tag_category' => CmsTagCategory::class,
    ],

    'column_names' => [
        'created_by' => 'created_by',
        'updated_by' => 'updated_by',
    ],

    'cache' => [
        'available_page_slug' => [
            'name' => 'cms_page_available_slug',
            'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        ],
    ],
];
