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
        $title1 = data_get($page->data, 'title1', '');
        $subtitle = data_get($page->data, 'subtitle', '');
        $button_link = data_get($page->data, 'button_link', '#');
        $button_text = data_get($page->data, 'button_text', '');
        $my_story = data_get($page->data, 'my_story', '');
    @endphp

    <div class="border-b border-grey-lighter py-16 lg:py-20">
        <div>
          <img src="/assets/img/mini-logo.png" class="h-16 w-16" alt="author">
        </div>
        <h1 class="pt-3 font-body text-4xl font-semibold text-primary dark:text-white md:text-5xl lg:text-6xl">
            {{ $title1 }}
        </h1>
        <p class="pt-3 font-body text-xl font-light text-primary dark:text-white">
            {{ $subtitle  }}
        </p>
        <a href="{{ $button_link  }}" class="mt-12 block bg-secondary px-10 py-4 text-center font-body text-xl font-semibold text-white transition-colors hover:bg-green sm:inline-block sm:text-left sm:text-2xl">
          {{ $button_text }}
        </a>
      </div>

      <div class="border-b border-grey-lighter py-16 lg:py-20">
        <div class="flex items-center pb-6">
          <img src="/assets/img/icon-story.png" alt="icon story">
          <h3 class="ml-3 font-body text-2xl font-semibold text-primary dark:text-white">
            My Story
          </h3>
        </div>
        <div>
          <p class="font-body font-light text-primary dark:text-white">
            {!! $my_story !!}
          </p>
        </div>
      </div>

      <div class="py-16 lg:py-20">
        <div class="flex items-center pb-6">
          <img src="/assets/img/icon-story.png" alt="icon story">
          <h3 class="ml-3 font-body text-2xl font-semibold text-primary dark:text-white">
            My Blogs
          </h3>
          <a href="/blogs" class="flex items-center pl-10 font-body italic text-green transition-colors hover:text-secondary dark:text-green-light dark:hover:text-secondary">
            All posts
            <img src="/assets/img/long-arrow-right.png" class="ml-3" alt="arrow right">
          </a>
        </div>
        <div class="pt-8">
            @php
                $blogs = \SolutionForest\FilamentCms\Support\Utils::getContentType('blogs')->paginate(5);
            @endphp
            @foreach($blogs as $index => $blog)

              @php
                  $categoryTags = $blog->tags->filter(fn ($tag) => $tag->category == 'category');
              @endphp
                <div 
                @class([
                    'border-b border-grey-lighter pb-8',
                    'pt-10' => $index !== 0,
                ])>
                  @foreach ($categoryTags as $categoryTag)
                    <span class="mb-4 inline-block rounded-full bg-green-light px-2 py-1 font-body text-sm text-green">
                      {{ $categoryTag->title }}
                    </span>
                  @endforeach
                    <a href="{{ $blog->draftPage->getUrl()}}" class="block font-body text-lg font-semibold text-primary transition-colors hover:text-green dark:text-white dark:hover:text-secondary">
                        {{ $blog->title }}
                    </a><div class="flex items-center pt-4">
                        <p class="pr-2 font-body font-light text-primary dark:text-white">
                            {{ $blog->published_at->format('M d, Y') }}
                        </p>
                      <span class="font-body text-grey dark:text-white">//</span>
                      <p class="pl-2 font-body font-light text-primary dark:text-white">
                        {{ $blog->createdBy->name }}
                    </p>
                    </div>
                  </div>

          @endforeach
        </div>
      </div>

      <div class="pb-16 lg:pb-20">
        <div class="flex items-center pb-6">
          <img src="/assets/img/icon-project.png" alt="icon story">
          <h3 class="ml-3 font-body text-2xl font-semibold text-primary dark:text-white">
            Related Links
          </h3>
        </div>
        <div>
            @php
                $links = \SolutionForest\FilamentCms\Support\Utils::getDataType('link')->get();
            @endphp
            @foreach($links as $link)
            @php
                $url = data_get($link->data, 'url', '#');
                $description = data_get($link->data, 'description', '');
            @endphp
            <a href="{{ $url }}" class="mb-6 flex items-center justify-between border border-grey-lighter px-4 py-4 sm:px-6">
              <span class="w-9/10 pr-8">
                <h4 class="font-body text-lg font-semibold text-primary dark:text-white">
                    {{ $link->title ?? '' }}
                </h4>
                <p class="font-body font-light text-primary dark:text-white">
                    {{ $description  }}
                </p>
              </span>
              <span class="w-1/10">
                <img src="/assets/img/chevron-right.png" class="mx-auto" alt="chevron right">
              </span>
            </a>

            @endforeach
          
        </div>
      </div>

</x-dynamic-component>
