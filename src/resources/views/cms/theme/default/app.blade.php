@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;
    
    /** @var ?\SolutionForest\FilamentCms\SEO\Support\SEOData $seo */
    
    $theme = FilamentCms::getCurrentTheme();
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />

    @isset($seo)
        {!! seo($seo) !!}
    @endisset
    @stack('beforeCoreStyles')
    @livewireStyles
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body x-data="{ isMobileMenuOpen: false }"
    :class="{
        'max-h-screen overflow-hidden relative' : isMobileMenuOpen,
    }"
    class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">

    @section('header')
        @include("cms.theme.{$theme}.header")
    @show

    <div class="container mx-auto py-6 lg:py-10">
        @yield('content')
    </div>

    @section('footer')
        @include("cms.theme.{$theme}.footer")
    @show

    @stack('beforeCoreScripts')
    @livewireScriptConfig 
    @vite(['resources/js/app.js'])
    @stack('scripts')

</body>

</html>
