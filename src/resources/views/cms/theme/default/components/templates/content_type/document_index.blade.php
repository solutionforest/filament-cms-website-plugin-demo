@props(['layout', 'page' => null])
@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();

    $childs = null;

    if ($page) {
        $query = \SolutionForest\FilamentCms\Support\Utils::getContentType($page->slug)
            // document is avoid to be edited
            ->published();
        $childs = $query->get();
    }
@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">
    <div class="p-4">
        <span class="text-2xl text-gray-600 my-10 dark:text-white">
            Filament CMS Documentation
        </span>
    </div>
    @if ($childs)
        <div class="mt-4 grid grid-cols-2 gap-4">
            @foreach ($childs as $docPage)
                <a href="{{ $docPage->getUrl() }}">
                    <div class="border rounded-xl shadow-md p-4">
                        {{ $docPage->title }}
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-dynamic-component>
