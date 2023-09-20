@props(['layout', 'page' => null])
@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();
    
    $sections = data_get($page->data ?? [], 'sections');

    $tableOfContents = collect($sections)->pluck('name', 'section_id');

    $parentPageModel = $page->getPageModel()?->parentPage;
    $parentPage = $parentPageModel 
        ? \SolutionForest\FilamentCms\Dto\CmsPageData::fromModel($parentPageModel)
        : null;
@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">

    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                    Home
                </a>
            </li>
            @if ($parentPage)
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ $parentPage->getUrl() }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{ $parentPage->title }}
                        </a>
                    </div>
                </li>
            @endif
            <li aria-current="page">
                <div class="flex items-center">
                <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                    {{ $page->title }}
                </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="prose py-5">
        <h2>Table of contents</h2>
        <ul class="table-of-contents">
            @foreach ($tableOfContents as $sectionId => $sectionTitle)
                <li>
                    <a href="#{{ $sectionId }}">{{ $sectionTitle }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    
    <div class="p-2 border border-gray-100 p-4 rounded-xl shadow-md bg-white">
        <article class="prose max-w-none p-4">
            @if ($sections)
                @foreach ($sections as $section)
                    @php
                        $sectionId = data_get($section, 'section_id');
                    @endphp
                    <h2>
                        <a href="#{{ $sectionId }}" id="{{ $sectionId }}" class="heading-anchor" title="Permalink">
                            {{ data_get($section, 'name') }}
                        </a>
                    </h2>
                    @isset($section['content'])
                        {!! $section['content'] !!}
                    @endisset
                    <hr/>
                @endforeach
            @endif
        </article>
    </div>
</x-dynamic-component>
