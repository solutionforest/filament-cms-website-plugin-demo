@php
    $menu = \SolutionForest\FilamentCms\Facades\FilamentCms::getNavigation('main-menu') ?? [];
    $locale = \Illuminate\Support\Facades\App::getLocale();
@endphp
<div class="container mx-auto">
    <div class="flex items-center justify-between py-6 lg:py-10">
        <a href="/" class="flex items-center">
            <p class="hidden font-body text-2xl font-bold text-primary dark:text-white lg:block">
                Demo Site
            </p>
        </a>
        <div class="flex items-center lg:hidden">
            <i class="bx mr-8 cursor-pointer text-3xl text-primary dark:text-white bxs-sun" @click="themeSwitch()"
                :class="isDarkMode ? 'bxs-sun' : 'bxs-moon'"></i>

            <svg width="24" height="15" xmlns="http://www.w3.org/2000/svg" @click="isMobileMenuOpen = true"
                class="fill-current text-primary dark:text-white">
                <g fill-rule="evenodd">
                    <rect width="24" height="3" rx="1.5"></rect>
                    <rect x="8" y="6" width="16" height="3" rx="1.5"></rect>
                    <rect x="4" y="12" width="20" height="3" rx="1.5"></rect>
                </g>
            </svg>
            <div x-show="isMobileMenuOpen" class="flex justify-center text-primary " style="display: none">
                <div class="absolute flex h-screen right-0 top-0"  @click.away="isMobileMenuOpen = false">
                    <div class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl text-sm bg-white text-primary leading-6 shadow-lg ring-1 ring-gray-900/5">
                        <div class="p-4">
                            @foreach ($menu as $item)
                                @php
                                    $url = $item->url ?? '#';
                                    if ($queryString = request()->getQueryString()) {
                                        $url .= '?' . $queryString;
                                    }
                                @endphp
                                
                                <a href="{{ $url }}">
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="font-semibold text-gray-900">
                                            {{ $item->title }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block">
            <ul class="flex items-center">

                @foreach ($menu as $item)
                    @php
                        $url = $item->url ?? '#';
                        if ($queryString = request()->getQueryString()) {
                            $url .= '?' . $queryString;
                        }
                    @endphp
                    <li class="group relative mr-6 mb-1">
                        <div
                        class="absolute left-0 bottom-0 z-20 h-0 w-full opacity-75 transition-all group-hover:h-2 group-hover:bg-yellow">
                            </div>
                        <a href="{{ $url }}"
                            class="relative z-30 block px-2 font-body text-lg font-medium text-primary transition-colors group-hover:text-green dark:text-white dark:group-hover:text-secondary">{{ $item->title }}</a>
                    </li>
                @endforeach

                <li class="group relative mr-6 mb-1">
                    <a href="{{ route('locale.switch', ['locale' => $locale == 'en' ? 'zh-HK' : 'en']) }}" 
                        class="ml-6 inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold shadow-sm hover:bg-gray-400">
                        {{ $locale == 'en' ? '繁' : 'Aa' }}
                    </a>
                </li>

                <li class="group relative mr-6 mb-1">
                    <a href="#" @click="themeSwitch()" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold shadow-sm hover:bg-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16" x-show="isDarkMode">
                            <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16" x-show="! isDarkMode">
                            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
