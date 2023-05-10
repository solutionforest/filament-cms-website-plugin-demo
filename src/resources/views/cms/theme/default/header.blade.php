@php
    $menu = \SolutionForest\FilamentCms\Facades\FilamentCms::getNavigation('main-menu') ?? [];
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

                <li>
                    <i class="bx cursor-pointer text-3xl text-primary dark:text-white" @click="themeSwitch()"
                        :class="isDarkMode ? 'bxs-sun' : 'bxs-moon'"></i>
                </li>
            </ul>
        </div>
    </div>
</div>
