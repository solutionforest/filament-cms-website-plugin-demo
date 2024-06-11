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
    
    @php
        $title = $page->title ?? '';
        $description = $page->content ?? '';
    @endphp
    <div class="py-16 lg:py-20">
        <div>
          <img src="/assets/img/icon-blog.png" alt="icon envelope">
        </div>
    
        <h1 class="pt-5 font-body text-4xl font-semibold text-primary dark:text-white md:text-5xl lg:text-6xl">
          {{ $title }}
        </h1>
    
        <div class="pt-3 sm:w-3/4">
          <p class="font-body text-xl font-light text-primary dark:text-white">
            {{ $description }}
          </p>
        </div>
    
        <div class="pt-8 lg:pt-12">
        @php
            $perPage = 2;
            $currPage = request()->get('page') ?? 1;
            $blogs = \SolutionForest\FilamentCms\Support\Utils::getContentType('blogs')
                ->paginate($perPage, page: $currPage);
        @endphp
        @foreach($blogs->items() as $index => $blog)

            @php
                $categoryTags = $blog->tags->filter(fn ($tag) => $tag->category == 'category');
            @endphp
          <div 
            @class([
                'border-b border-grey-lighter pb-8',
                'pt-10' => $index !== 0,
            ])>
            @foreach ($categoryTags as $categoryTag)
                <a href="#">
                    <span class="mb-4 inline-block rounded-full bg-green-light px-2 py-1 font-body text-sm text-green">
                        {{ $categoryTag->title }}
                    </span>
                </a>
            @endforeach
            <a href="{{ $blog->getUrl()}}" class="block font-body text-lg font-semibold text-primary transition-colors hover:text-green dark:text-white dark:hover:text-secondary">
                {{ $blog->title }}
            </a>
            <div class="flex items-center pt-4">
              <p class="pr-2 font-body font-light text-primary dark:text-white">
                {{ $blog->publishedAt?->format('M d, Y') }}
              </p>
              <span class="font-body text-grey dark:text-white">//</span>
              <p class="pl-2 font-body font-light text-primary dark:text-white">
                {{ $blog->createdBy?->name }}
              </p>
            </div>
          </div>
        @endforeach
        </div>
    
        @php
            $currUrl = request()->url();
            $requestQuery = collect(request()->query())->except('page')->map(fn ($v, $k) => "$k=$v");
        @endphp
        @if ($blogs->hasPages())
            <div class="flex pt-8 lg:pt-16">
                @if (! $blogs->onFirstPage())
                    <a href="{{ str($currUrl)->finish('?')->finish($requestQuery->push('page='.$currPage - 1)->implode('&')) }}">
                        <span class="group ml-3 flex cursor-pointer items-center border-2 border-primary px-3 py-1 font-body font-medium text-primary transition-colors hover:border-secondary hover:text-secondary dark:border-green-light dark:text-white dark:hover:border-secondary dark:hover:text-secondary">
                            Previous
                            <i class="bx bx-left-arrow-alt ml-1 text-primary transition-colors group-hover:text-secondary dark:text-white"></i>
                        </span>
                    </a>
                @endif
                @foreach ($blogs->render()->offsetGet('elements') as $element)
                    @if (is_string($element))
                        <button disabled type="button">
                            <span>
                                {{ $element }}
                            </span>
                        </button>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <a href="{{ $url }}">
                                <span class="ml-3 flex cursor-pointer items-center border-2 border-primary px-3 py-1 font-body font-medium text-primary transition-colors hover:border-secondary hover:text-secondary dark:border-green-light dark:text-white dark:hover:border-secondary dark:hover:text-secondary">
                                    {{ $page }}
                                </span>
                            </a>
                        @endforeach
                    @endif
                @endforeach
                @if ($blogs->hasMorePages())
                    <a href="{{ str($currUrl)->finish('?')->finish($requestQuery->push('page='.$currPage + 1)->implode('&')) }}">
                        <span class="group ml-3 flex cursor-pointer items-center border-2 border-primary px-3 py-1 font-body font-medium text-primary transition-colors hover:border-secondary hover:text-secondary dark:border-green-light dark:text-white dark:hover:border-secondary dark:hover:text-secondary">
                            Next
                            <i class="bx bx-right-arrow-alt ml-1 text-primary transition-colors group-hover:text-secondary dark:text-white"></i>
                        </span>
                    </a>
                @endif
            </div>
        @endif
    </div>

</x-dynamic-component>
