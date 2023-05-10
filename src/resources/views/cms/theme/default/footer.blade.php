@php
    $menu = \SolutionForest\FilamentCms\Facades\FilamentCms::getNavigation('footer') ?? [];
@endphp
<div class="container mx-auto">
    <div class="flex flex-col items-center justify-between border-t border-grey-lighter py-10 sm:flex-row sm:py-12">
        <div class="mr-auto flex flex-col items-center sm:flex-row">
            <a href="/" class="mr-auto sm:mr-6">
                <img src="/assets/img/mini-logo.png" alt="logo" class="w-12 h-12">
            </a>
            <p class="pt-5 font-body font-light text-primary dark:text-white sm:pt-0">
                ©{{ now()->year }} Solution Forest Limited.
            </p>
        </div>
        <div class="mr-auto flex items-center pt-5 sm:mr-0 sm:pt-0">

            @foreach ($menu as $item)
                @php
                    $url = $item->url ?? '#';
                    if ($queryString = request()->getQueryString()) {
                        $url .= '?' . $queryString;
                    }
                @endphp

                <a href="{{ $url }}" target="{{ $item->target }}">
                    <svg class="w-12 text-4xl text-primary dark:text-white pl-5 hover:text-secondary dark:hover:text-secondary transition-colors bx"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>

                </a>
            @endforeach

        </div>
    </div>
</div>
