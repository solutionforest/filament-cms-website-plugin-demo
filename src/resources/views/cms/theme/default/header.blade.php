@php
    $menu = \SolutionForest\FilamentCms\Facades\FilamentCms::getNavigation('main-menu') ?? [];
    $locale = \Illuminate\Support\Facades\App::getLocale();
    $docLink = 'https://solutionforest.github.io/plugins-doc-site/docs/filament-cms-website-plugin';
@endphp
<header class="bg-white dark:bg-gray-900 shadow-md border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto">
        <div class="flex items-center justify-between py-4 lg:py-6">
            <a href="/" class="flex items-center">
                <p class="font-sans text-xl lg:text-2xl font-bold text-primary dark:text-white">
                    Demo Site
                </p>
            </a>
            <div class="lg:hidden">
                <div class="flex items-center space-x-2">
                    <button @click="isMobileMenuOpen = true" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg width="24" height="15" xmlns="http://www.w3.org/2000/svg" 
                            class="fill-current text-primary dark:text-white"
                        >
                            <g fill-rule="evenodd">
                                <rect width="24" height="3" rx="1.5"></rect>
                                <rect x="8" y="6" width="16" height="3" rx="1.5"></rect>
                                <rect x="4" y="12" width="20" height="3" rx="1.5"></rect>
                            </g>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Backdrop -->
                <div x-show="isMobileMenuOpen" class="fixed inset-0 z-50" x-cloak>
                    <!-- Backdrop -->
                    <div @click="isMobileMenuOpen = false" class="absolute inset-0 bg-black bg-opacity-50"></div>
                    
                    <!-- Menu Panel -->
                    <div class="relative ml-auto h-full w-full max-w-sm bg-white dark:bg-gray-900 shadow-xl">
                        <div class="p-6 h-full">
                            <button @click="isMobileMenuOpen = false" class="absolute top-2 right-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            
                            <nav class="flex flex-col mt-6 pb-4 h-full">
                                <!-- Navigation Menu Items -->
                                <div class="space-y-2 flex-1">
                                    @foreach ($menu as $item)
                                        @php
                                            $url = $item->url ?? '#';
                                            if ($queryString = request()->getQueryString()) {
                                                $url .= '?' . $queryString;
                                            }
                                        @endphp
                                        
                                        <a href="{{ $url }}" @click="isMobileMenuOpen = false" class="block px-4 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-primary-lighter/20 transition-colors">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $item->title }}</span>
                                        </a>
                                    @endforeach
                                </div>

                                {{-- <div class="border-t border-gray-200 dark:border-gray-700 pt-4"></div> --}}
                                
                                <!-- Action Items at Bottom -->
                                <div class="mt-auto space-y-2">
                                    
                                    <a href="{{ $docLink }}" target="_blank" rel="noopener noreferrer" class="flex items-center px-4 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-primary-lighter/20 transition-colors">
                                        <span class="font-medium text-gray-900 dark:text-white mr-2">Docs</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Admin Link -->
                                    <a href="/admin" class="flex items-center px-4 py-3 rounded-lg hover:bg-primary/10 dark:hover:bg-primary-lighter/20 transition-colors">
                                        Admin Panel
                                    </a>
                                    
                                    <!-- Language Selector and Theme Toggle on same line -->
                                    <div class="flex items-center space-x-3">
                                        <!-- Language Selector (takes more width) -->
                                        <div class="flex-1">
                                            <select onchange="window.location.href = this.value" class="w-full px-3 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white transition-colors border-0 focus:ring-2 focus:ring-primary focus:outline-none">
                                                <option value="{{ route('locale.switch', ['locale' => 'en']) }}" {{ $locale == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="{{ route('locale.switch', ['locale' => 'zh-HK']) }}" {{ $locale == 'zh-HK' ? 'selected' : '' }}>繁體中文</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Theme Toggle (smaller width) -->
                                        <div class="flex-shrink-0">
                                            <button @click="$store.theme.toggleTheme()" class="flex items-center justify-center w-12 h-10 px-3 py-2 rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16" x-show="$store.theme.isDarkMode()">
                                                    <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16" x-show="! $store.theme.isDarkMode()">
                                                    <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                @foreach ($menu as $item)
                    @php
                        $url = $item->url ?? '#';
                        if ($queryString = request()->getQueryString()) {
                            $url .= '?' . $queryString;
                        }
                    @endphp
                    <a href="{{ $url }}" class="relative px-3 py-2 font-medium text-primary dark:text-white hover:text-primary/80 dark:hover:text-primary-lighter transition-colors group">
                        <span>{{ $item->title }}</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all group-hover:w-full"></span>
                    </a>
                @endforeach

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>

                <div class="flex items-center space-x-3">
                    <a href="{{ $docLink }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition-colors">
                        <span class="mr-2">Docs</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
                        </svg>
                    </a>

                    <!-- Admin Link -->
                    <a href="/admin" class="px-3 py-2 text-sm font-medium text-primary dark:text-white hover:text-primary/80 dark:hover:text-primary-lighter transition-colors">
                        Admin Panel
                    </a>

                    <!-- Language Selector -->
                    <select onchange="window.location.href = this.value" class="px-3 py-2 text-sm font-medium rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition-colors border-0 focus:ring-2 focus:ring-primary focus:outline-none">
                        <option value="{{ route('locale.switch', ['locale' => 'en']) }}" {{ $locale == 'en' ? 'selected' : '' }}>EN</option>
                        <option value="{{ route('locale.switch', ['locale' => 'zh-HK']) }}" {{ $locale == 'zh-HK' ? 'selected' : '' }}>繁</option>
                    </select>

                    <!-- Theme Toggle -->
                    <button @click="$store.theme.toggleTheme()" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high-fill" viewBox="0 0 16 16" x-show="$store.theme.isDarkMode()">
                            <path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16" x-show="! $store.theme.isDarkMode()">
                            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
