@props(['layout', 'page' => null])
@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();
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
            @foreach ($breadcrumbs ?? [] as $item)
                @php
                    $url = $item['url'] ?? '';
                    $label = $item['label'] ?? $item['title'];
                @endphp
                @if (empty($label))
                    @continue
                @endif
                    
                <li @if ($loop->last) aria-current="page" @endif>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        @if (!$loop->last)
                            <a href="{{ $url }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                                {{ $label }}
                            </a>
                        @else
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                                {{ $label }}
                            </span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>

        @isset($versions)
        <ol class="inline-flex items-center space-x-1 md:space-x-3 ml-auto">
            <li class="inline-flex items-center">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-400">Version:</span>
            </li>
            @foreach ($versions as $key => $item)
                @php
                    $isCurrentVersion = $key === $version;
                @endphp
                <li>
                    <a href="{{ $item['url'] }}" @class([
                        'inline-flex items-center text-sm ',
                        'text-blue-600 hover:text-blue-700 dark:hover:text-white',
                        'font-medium' => !$isCurrentVersion,
                        'underline font-semibold' => $isCurrentVersion,
                    ])>
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ol>
        @endisset
    </nav>
    
    <div class="p-2 border border-gray-100 p-4 rounded-xl shadow-md bg-white">
        <article class="prose max-w-none p-4" x-data="mdContent" x-html="markdownContent">
        </article>
    </div>

    @pushOnce('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mdContent', function () {
                const url = @js(route('docs.get.markdown', ['document' => $document, 'version' => $version ?? null]));
                return {
                    markdownContent: null,
                    loadingHtml: '<div class="text-center text-gray-500">Loading...</div>',
                    init() {
                        this.markdownContent = this.loadingHtml;
                        this.$nextTick(() => {
                            this.getContent();
                        });
                    },
                    getContent() {
                        fetch(url)
                            .then(response => response.text())
                            .then(data => {
                                try {
                                    this.markdownContent = JSON.parse(data).content;
                                } catch (e) {
                                    console.error('Failed to parse JSON:', e);
                                    this.markdownContent = '';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching markdown content:', error);
                            });
                    }
                };
            });
        });
    </script>
    @endPushOnce
</x-dynamic-component>
