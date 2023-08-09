@props(['layout', 'page' => null])
@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();
    $content = data_get($page->data, 'content' , '');
    $categoryTags = $page->tags->filter(fn ($tag) => $tag->category == 'category');

@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">

    <div class="pt-16 lg:pt-20">
        <div class="border-b border-grey-lighter pb-8 sm:pb-12">
          @foreach ($categoryTags as $categoryTag)
            <a href="#">
              <span class="mb-5 inline-block rounded-full bg-green-light px-2 py-1 font-body text-sm text-green sm:mb-8">
                {{ $categoryTag->title }}
              </span>
            </a>
          @endforeach
          <h2 class="block font-body text-3xl font-semibold leading-tight text-primary dark:text-white sm:text-4xl md:text-5xl">
            {{ $page->title }}
          </h2>
          <div class="flex items-center pt-5 sm:pt-8">
            <p class="pr-2 font-body font-light text-primary dark:text-white">
                {{ $page->published_at?->format('M d, Y') }}
            </p>
            <span class="vdark:text-white font-body text-grey">//</span>
            <p class="pl-2 font-body font-light text-primary dark:text-white">
                {{ $page->createdBy->name }}
            </p>
          </div>
        </div>
        <div class="prose prose max-w-none border-b border-grey-lighter py-8 dark:prose-dark sm:py-12 text-primary dark:text-white">
         {!! $content !!}
        </div>
      </div>
</x-dynamic-component>
