<section class="mt-12 lg:mt-40">
    @include('layouts._sponsors')
</section>

<div class="mt-14 bg-gray-900 text-white lg:mt-40">
    <div class="container mx-auto pb-8 pt-7 lg:px-16 lg:pt-20">
        <div class="mx-4 md:mx-0">
            <div class="mb-8 flex flex-col border-b border-gray-800 pb-8 lg:flex-row lg:pb-16">
                <div class="mb-6 w-full lg:mb-0 lg:w-2/5 lg:pr-20">
                    <img
                        loading="lazy"
                        src="{{ asset('images/laravelio-logo-white.svg') }}"
                        alt="{{ config('app.name') }}"
                        class="mb-5 block"
                    />

                    <p class="text-gray-100 lg:leading-loose">
                        The Laravel portal for problem solving, knowledge sharing and community building.
                    </p>
                </div>

                <div class="lg:flex lg:w-full lg:justify-between">
                    <div class="mb-6 grow lg:mb-0">
                        <p class="mb-4 text-lg lg:mb-6">Laravel.io</p>

                        <div class="lg:flex-no-wrap flex flex-wrap lg:flex-col">
                            <a
                                href="{{ route('forum') }}"
                                class="mb-4 w-1/2 text-gray-400 hover:text-gray-200 lg:mb-6"
                            >
                                Forum
                            </a>

                            <a
                                href="{{ route('articles') }}"
                                class="mb-4 w-1/2 text-gray-400 hover:text-gray-200 lg:mb-6"
                            >
                                Articles
                            </a>

                            <a
                                href="https://paste.laravel.io"
                                class="mb-4 w-1/2 text-gray-400 hover:text-gray-200 lg:mb-6"
                            >
                                Pastebin
                            </a>
                        </div>
                    </div>

                    <div class="mb-6 grow lg:mb-0">
                        <p class="mb-4 text-lg lg:mb-6">Socials</p>

                        <div class="lg:flex-no-wrap flex flex-wrap lg:flex-col">
                            <a
                                href="https://twitter.com/laravelio"
                                class="mb-4 w-1/2 text-gray-400 hover:text-gray-200 lg:mb-6"
                            >
                                <x-si-x class="mr-3.5 inline h-4 w-4 text-white" />
                                Twitter
                            </a>

                            <a
                                href="https://github.com/laravelio"
                                class="mb-4 w-1/2 text-gray-400 hover:text-gray-200 lg:mb-6"
                            >
                                <x-icon-github class="mr-3.5 inline h-4 w-4 text-white" />
                                GitHub
                            </a>
                        </div>
                    </div>

                    <div class="grow">
                        <p class="mb-6 text-lg">The community</p>

                        <div class="flex flex-col flex-nowrap">
                            <div class="mb-4 flex lg:mb-6">
                                <a href="https://laravel.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img
                                        loading="lazy"
                                        src="{{ asset('images/laravel.png') }}"
                                        alt="Laravel"
                                        class="mr-2 inline h-4 w-4"
                                    />
                                    Laravel
                                </a>

                                <a href="https://laravel-news.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img
                                        loading="lazy"
                                        src="{{ asset('images/laravel-news.png') }}"
                                        alt="Laravel News"
                                        class="mr-2 inline h-4 w-4"
                                    />
                                    Laravel News
                                </a>
                            </div>

                            <div class="flex">
                                <a href="https://laracasts.com" class="w-1/2 text-gray-400 hover:text-gray-200">
                                    <img
                                        loading="lazy"
                                        src="{{ asset('images/laracasts.png') }}"
                                        alt="Laracasts"
                                        class="mr-2 inline h-4 w-4"
                                    />
                                    Laracasts
                                </a>

                                <a
                                    href="https://www.laravelpodcast.com"
                                    class="w-1/2 text-gray-400 hover:text-gray-200"
                                >
                                    <img
                                        loading="lazy"
                                        src="{{ asset('images/podcast.png') }}"
                                        alt="Laravel Podcast"
                                        class="mr-2 inline h-4 w-4"
                                    />
                                    Laravel Podcast
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col text-gray-100 lg:flex-row">
                <span class="mb-5 lg:mb-0 lg:mr-5">&copy; {{ date('Y') }} Laravel.io - All rights reserved.</span>

                <div class="flex flex-wrap lg:block">
                    <a href="{{ route('terms') }}" class="mb-4 w-1/2 hover:text-gray-200 lg:mb-0 lg:mr-8 lg:w-full">
                        Terms of service
                    </a>
                    <a href="{{ route('privacy') }}" class="mb-4 w-1/2 hover:text-gray-200 lg:mb-0 lg:mr-8 lg:w-full">
                        Privacy policy
                    </a>
                    <a href="https://github.com/sponsors/laravelio" class="w-1/2 hover:text-gray-200 lg:mb-0 lg:w-full">
                        Advertise
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
