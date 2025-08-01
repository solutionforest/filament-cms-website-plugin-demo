@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();
@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">
    <div class="p-4">
        <span class="text-2xl text-gray-600 my-10 dark:text-white">
            Documentation
        </span>
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($childs as $key => $data)
            <a href="{{ $data['url'] ?? '' }}" class="rounded-xl shadow-md flex items-center justify-between border border-grey-lighter px-4 py-4 sm:px-6 hover:bg-grey-lighter transition-colors dark:border-white dark:hover:bg-gray-700 group dark:border-gray-500">
              <span class="w-9/10 pr-8">
                <h4 class="font-sans text-lg font-semibold text-primary dark:text-white">
                    {{ $data['title'] ?? $key }}
                </h4>
              </span>
            </a>
        @endforeach
    </div>
</x-dynamic-component>
