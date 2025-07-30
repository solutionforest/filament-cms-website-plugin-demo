@php
    use SolutionForest\FilamentCms\Facades\FilamentCms;

    /** @var array $layout */
    /** @var ?\SolutionForest\FilamentCms\Dto\CmsPageData $page */

    $theme = FilamentCms::getCurrentTheme();
@endphp

<x-dynamic-component
    component="filament-cms::{{$theme}}.page"
    :layout="$layout">

    @section('footer')
    @endsection
    
    @pushOnce('styles')
        @vite('resources/css/contact-form.css')
    @endPushOnce
    @pushOnce('beforeCoreScripts')
        @livewireScriptConfig 
        @vite('resources/js/contact-form.js')
    @endPushOnce
    @pushOnce('scripts')
        @livewire('notifications')
    @endPushOnce

    <div class="p-4">
        <span class="text-2xl text-gray-600 my-10 dark:text-white">
            Contact Form
        </span>
    </div>

    {{-- <x-simple-contact-form :form="$form->getKey()" /> --}}
    <div class="w-auto">
        @if($form)
            <livewire:contact-form :id="$form->getKey()" />
        @else
            <div class="p-4 bg-red-100 text-red-800 rounded">
                Contact form not found. Please provide a valid form ID.
            </div>
        @endif
    </div>

</x-dynamic-component>

