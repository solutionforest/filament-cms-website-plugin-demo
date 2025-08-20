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
            @foreach ([
                ['url' => '/', 'label' => 'Home'],
                ...$breadcrumbs ?? [],
            ] as $item)
                @php
                    $url = $item['url'] ?? '';
                    $label = $item['label'] ?? $item['title'];
                @endphp
                @if (empty($label))
                    @continue
                @endif
                    
                <li @if ($loop->last) aria-current="page" @endif>
                    <div class="flex items-center">
                        @if (! $loop->first)
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        @else
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                        @endif
                        @if (!$loop->last)
                            <a href="{{ $url }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-green md:ml-2 dark:text-gray-400 dark:hover:text-white">
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
                        'text-blue hover:text-green dark:text-gray-400 dark:hover:text-white',
                        'font-medium' => !$isCurrentVersion,
                        'underline font-bold' => $isCurrentVersion,
                    ])>
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ol>
        @endisset
    </nav>
    
    <div class="mt-4 p-2 border border-gray-100 p-4 rounded-xl shadow-md bg-white">
        @isset($github)
            <a
                color="gray"
                href="{{ $github }}"
                target="_blank"
            >
                <svg class="w-8 h-8 text-gray-500 dark:text-gray-400 ml-auto"
                    viewBox="0 0 98 96"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        clip-rule="evenodd"
                        fill="currentColor"
                        fill-rule="evenodd"
                        d="M48.854 0C21.839 0 0 22 0 49.217c0 21.756 13.993 40.172 33.405 46.69 2.427.49 3.316-1.059 3.316-2.362 0-1.141-.08-5.052-.08-9.127-13.59 2.934-16.42-5.867-16.42-5.867-2.184-5.704-5.42-7.17-5.42-7.17-4.448-3.015.324-3.015.324-3.015 4.934.326 7.523 5.052 7.523 5.052 4.367 7.496 11.404 5.378 14.235 4.074.404-3.178 1.699-5.378 3.074-6.6-10.839-1.141-22.243-5.378-22.243-24.283 0-5.378 1.94-9.778 5.014-13.2-.485-1.222-2.184-6.275.486-13.038 0 0 4.125-1.304 13.426 5.052a46.97 46.97 0 0 1 12.214-1.63c4.125 0 8.33.571 12.213 1.63 9.302-6.356 13.427-5.052 13.427-5.052 2.67 6.763.97 11.816.485 13.038 3.155 3.422 5.015 7.822 5.015 13.2 0 18.905-11.404 23.06-22.324 24.283 1.78 1.548 3.316 4.481 3.316 9.126 0 6.6-.08 11.897-.08 13.526 0 1.304.89 2.853 3.316 2.364 19.412-6.52 33.405-24.935 33.405-46.691C97.707 22 75.788 0 48.854 0z"
                    />
                </svg>
            </a>
        @endisset
        <article class="prose max-w-none p-4" x-data="mdContent" x-html="markdownContent">
        </article>
    </div>

    

    @pushOnce('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mdContent', function () {
                const url = @js(route('docs.get.markdown', ['document' => $document, 'version' => $githubBranch ?? null]));
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
