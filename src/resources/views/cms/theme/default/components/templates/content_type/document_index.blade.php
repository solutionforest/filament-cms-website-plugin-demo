@props(['layout', 'page' => null])
@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();

    $childs = null;

    if ($page) {
        $query = \SolutionForest\FilamentCms\Support\Utils::getContentType($page->slug);
        if (request()->has('preview')) {
            $query = $query->preview();
        } else {
            $query = $query->published();
        }
        $childs = $query->get();
    }
@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">
    <div class="border border-gray-100 p-4 rounded-xl shadow-md">
        <span class="text-2xl text-gray-600 my-10 dark:text-white">
            Filament CMS Documentation
        </span>
    </div>
    @if ($childs)
        <div class="p-4">
            <ul class="list-disc">
                @foreach ($childs as $docPage)

                    <li>
                        <a href="{{ $docPage->getUrl() }}">
                            {{ $docPage->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</x-dynamic-component>
