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

    @if ($seo)
        {!! seo($seo) !!}
    @endif
    @stack('beforeCoreStyles')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/styles/main.min.css">
    @stack('styles')
</head>

<body x-data="global()" x-init="themeInit()"
    :class="isMobileMenuOpen ? 'max-h-screen overflow-hidden relative' : ''"
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

    <script src="/assets/js/main.min.js"></script>
    @stack('beforeCoreScripts')
    @stack('scripts')

</body>

</html>
