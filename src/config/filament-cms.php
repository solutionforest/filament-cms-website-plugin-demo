<?php

use SolutionForest\FilamentCms\CmsPages\Renderer;
use SolutionForest\FilamentCms\CmsPages\Templates;
use SolutionForest\FilamentCms\Filament\Resources;
use SolutionForest\FilamentCms\Http\Middleware;
use SolutionForest\FilamentCms\Models;

return [

    'theme' => 'default',

    'default_layout' => 'app',

    'locales' => [],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware for front-end pages
    |
    */
    'middleware' => [
        'web' => [],
    ],

    'filament' => [
        'resources' => [
            'cms_page' => Resources\CmsPageResource::class,
            'cms_page_navigation_category' => Resources\CmsPageNavigationCategoryResource::class,
        ],
        'navigation' => [
            'icon' => [
                Resources\CmsPageResource::class => 'heroicon-o-document',
                Resources\CmsPageNavigationCategoryResource::class => 'heroicon-o-menu',
            ],
            'sort' => [
                Resources\CmsPageResource::class => -3,
                Resources\CmsPageNavigationCategoryResource::class => -2,
            ],
        ],
        'recordTitleAttribute' => [
            'cms_page' => 'title',
            'cms_navigation_category' => 'title',
        ],
    ],
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
        'cms_page' => Models\CmsPage::class,
        'cms_published_page' => Models\CmsPublishedPage::class,
        'cms_page_navigation' => Models\CmsPageNavigation::class,
        'cms_page_navigation_category' => Models\CmsPageNavigationCategory::class,
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
