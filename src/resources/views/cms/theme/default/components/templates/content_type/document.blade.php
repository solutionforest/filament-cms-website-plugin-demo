@props(['layout', 'page' => null])
@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();
    
    $content = data_get($page->data ?? [], 'content');

@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">
    <div class="p-2 border border-gray-100 p-4 rounded-xl shadow-md bg-white">
        <article class="prose">
            @if ($content)
            {!! $content !!}
            @endif
        </article>
    </div>
</x-dynamic-component>
