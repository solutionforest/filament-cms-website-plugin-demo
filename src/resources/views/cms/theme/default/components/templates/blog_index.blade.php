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
            $blogs = \SolutionForest\FilamentCms\Support\Utils::getContentType('blogs')->get();
            
        @endphp
        @foreach($blogs as $index => $blog)

        <div 
                @class([
                    'border-b border-grey-lighter pb-8',
                    'pt-10' => $index !== 0,
                ])>
            <span class="mb-4 inline-block rounded-full bg-green-light px-2 py-1 font-body text-sm text-green">category</span>
            <a href="{{ $blog->draftPage->getUrl()}}" class="block font-body text-lg font-semibold text-primary transition-colors hover:text-green dark:text-white dark:hover:text-secondary">
                {{ $blog->title }}
            </a>
            <div class="flex items-center pt-4">
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
    
        <!-- Remove this part first , Next update will include pagination -->
        <!-- <div class="flex pt-8 lg:pt-16">
          <span class="cursor-pointer border-2 border-secondary px-3 py-1 font-body font-medium text-secondary">1</span>
          <span class="ml-3 cursor-pointer border-2 border-primary px-3 py-1 font-body font-medium text-primary transition-colors hover:border-secondary hover:text-secondary dark:border-green-light dark:text-white dark:hover:border-secondary dark:hover:text-secondary">2</span>
          <span class="ml-3 cursor-pointer border-2 border-primary px-3 py-1 font-body font-medium text-primary transition-colors hover:border-secondary hover:text-secondary dark:border-green-light dark:text-white dark:hover:border-secondary dark:hover:text-secondary">3</span>
          <span class="group ml-3 flex cursor-pointer items-center border-2 border-primary px-3 py-1 font-body font-medium text-primary transition-colors hover:border-secondary hover:text-secondary dark:border-green-light dark:text-white dark:hover:border-secondary dark:hover:text-secondary">Next
            <i class="bx bx-right-arrow-alt ml-1 text-primary transition-colors group-hover:text-secondary dark:text-white"></i></span>
        </div>  -->
      </div>

</x-dynamic-component>
