<section class="mb-14 lg:mb-40">
    @include('layouts._sponsors')
</section>

<div class="bg-gray-900 text-white">
    <div class="container mx-auto pt-7 pb-8 lg:pt-20 lg:px-16">
        <div class="mx-4 md:mx-0">
            <div class="flex flex-col pb-8 mb-8 border-b lg:pb-16 border-gray-800 lg:flex-row">
                <div class="w-full mb-6 lg:w-2/5 lg:pr-20 lg:mb-0">
                    <a href="" class="block mb-5">
                        <img src="{{ asset('images/laravelio-logo-white.svg') }}" />
                    </a>

                    <p class="text-gray-100 lg:leading-loose">
                        The Laravel portal for problem solving, knowledge sharing and community building.
                    </p>
                </div>

                <div class="lg:w-full lg:flex lg:justify-between">
                    <div class="grow mb-6 lg:mb-0">
                        <h6 class="text-lg mb-4 lg:mb-6">
                            Laravel.io
                        </h6>

                        <div class="flex flex-wrap lg:flex-col lg:flex-no-wrap">
                            <a href="{{ route('forum') }}" class="w-1/2 text-gray-400 mb-4 hover:text-gray-200 lg:mb-6">
                                Forum
                            </a>

                            <a href="{{ route('articles') }}" class="w-1/2 text-gray-400 mb-4 hover:text-gray-200 lg:mb-6">
                                Articles
                            </a>

                            <a href="https://paste.laravel.io" class="w-1/2 text-gray-400 mb-4 hover:text-gray-200 lg:mb-6">
                                Pastebin
                            </a>
                        </div>
                    </div>

                    <div class="grow mb-6 lg:mb-0">
                        <h6 class="text-lg mb-4 lg:mb-6">
                            Socials
                        </h6>

                        <div class="flex flex-wrap lg:flex-col lg:flex-no-wrap">
                            <a href="https://twitter.com/laravelio" class="w-1/2 text-gray-400 mb-4 hover:text-gray-200 lg:mb-6">
                                <x-icon-twitter class="text-white w-4 h-4 inline mr-3.5"/>
                                Twitter
                            </a>

                            <a href="https://github.com/laravelio" class="w-1/2 text-gray-400 mb-4 hover:text-gray-200 lg:mb-6">
                                <x-icon-github class="text-white w-4 h-4 inline mr-3.5"/>
                                GitHub
                            </a>
                        </div>
                    </div>

                    <div class="grow">
                        <h6 class="text-lg mb-6">
                            The community
                        </h6>

                        <div class="flex flex-col flex-nowrap">
                            <div class="flex mb-4 lg:mb-6">
                                <a href="https://laravel.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img src="{{ asset('images/laravel.png') }}" alt="Laravel" class="w-4 h-4 inline mr-2" />
                                    Laravel
                                </a>

                                <a href="https://laravel-news.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img src="{{ asset('images/laravel-news.png') }}" alt="Laravel News" class="w-4 h-4 inline mr-2" />
                                    Laravel News
                                </a>
                            </div>

                            <div class="flex">
                                <a href="https://laracasts.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img src="{{ asset('images/laracasts.png') }}" alt="Laracasts" class="w-4 h-4 inline mr-2" />
                                    Laracasts
                                </a>

                                <a href="https://www.laravelpodcast.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img src="{{ asset('images/podcast.png') }}" alt="Laravel Podcast" class="w-4 h-4 inline mr-2" />
                                    Laravel Podcast
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-gray-100 flex flex-col lg:flex-row">
                <span class="mb-5 lg:mb-0 lg:mr-5">
                    &copy; {{ date('Y') }} Laravel.io - All rights reserved.
                </span>

                <div class="flex flex-wrap lg:block">
                    <a href="{{ route('terms') }}" class="w-1/2 mb-4 hover:text-gray-200 lg:w-full lg:mb-0 lg:mr-8">
                        Terms of service
                    </a>
                    <a href="{{ route('privacy') }}" class="w-1/2 mb-4 hover:text-gray-200 lg:w-full lg:mb-0 lg:mr-8">
                        Privacy policy
                    </a>
                    <a href="https://github.com/sponsors/laravelio" class="w-1/2 hover:text-gray-200 lg:w-full lg:mb-0">
                        Advertise
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
