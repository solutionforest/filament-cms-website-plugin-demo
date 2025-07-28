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
    <div class="mt-4 grid grid-cols-2 gap-4">
        @foreach ($childs as $key => $data)
            <a href="{{ $data['url'] ?? '' }}">
                <div class="border rounded-xl shadow-md p-4">
                    {{ $data['title'] ?? $key }}
                </div>
            </a>
        @endforeach
    </div>
</x-dynamic-component>
