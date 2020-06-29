@unless($disableFooterAds ?? false)
    <div class="container mx-auto px-4">
        @include('layouts._ads._footer')
    </div>
@endif

@include('layouts._sponsors')

<div class="bg-white">
    <div class="max-w-screen-xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
        <nav class="-mx-5 -my-2 flex flex-wrap justify-center">
            <div class="px-5 py-2">
                <a href="{{ route('terms') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                    Terms
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('privacy') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                    Privacy
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="javascript:window.Metomic('ConsentManager:show')"
                   class="text-base leading-6 text-gray-500 hover:text-gray-900">
                    Cookies
                </a>
            </div>
        </nav>
        <div class="mt-8 flex justify-center">
            <a href="https://twitter.com/laravelio" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Twitter</span>
                <x-icon-twitter class="text-gray-500 w-6 h-6"/>
            </a>
            <a href="https://github.com/laravelio" class="ml-6 text-gray-400 hover:text-gray-500">
                <span class="sr-only">GitHub</span>
                <x-icon-github class="text-gray-500 w-6 h-6"/>
            </a>
        </div>
        <div class="mt-8">
            <p class="text-center text-base leading-6 text-gray-400">
                &copy; {{ date('Y') }} Laravel.io - All rights reserved.
            </p>
        </div>
    </div>
</div>
