@props([
    'article' => null,
    'route',
    'method' => 'POST',
    'tags',
    'selectedTags' => []
])

<x-forms.form
    action="{{ route(...$route) }}"
    :method="$method"
>
    <div class="bg-gray-100 py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h2 id="create_thread_heading" class="text-lg leading-6 font-medium text-gray-900">
                @if ($article)
                    Update article
                @else
                    Write a new article
                @endif
            </h2>

            <x-info class="mt-4">
                Submit your article to the Laravel.io portal. We're looking for high quality articles revolving around Laravel, PHP, JavaScript, CSS, and related topics. Articles can't be promotional in nature and should be educational and informative. We reserve the right to decline articles that don't meet our quality standards.
            </x-info>

            <x-info class="mt-4">
                Every article that gets approved will be shared with our 50.000 users and wil be tweeted out on our <x-a href="https://x.com/laravelio">X (Twitter) account</x-a> which has over 50,000 followers as well as our <x-a href="https://bsky.app/profile/laravel.io">Bluesky account</x-a>. Feel free to submit as many articles as you like. You can even cross-reference an article on your blog with the original url.
            </x-info>

            <x-info class="mt-4">
                After submission for approval, articles are reviewed before being published. No notification of declined articles will be provided. Instead, we encourage to also cross-post articles on your own channel as well. <strong>After being published, you cannot edit your article anymore so please review it thoroughly before submitting for approval.</strong> Submitting the same article twice or posting spam will result in the banning of your account. We do not accept email requests for guest articles. Any such request will be ignored.
            </x-info>

            <x-rules-banner />
        </div>

        <div class="flex flex-col space-y-6">
            <div class="grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="title" />

                    <x-forms.inputs.input name="title" :value="old('title', $article?->title())" required maxlength="100" placeholder="My awesome article" />

                    <span class="mt-2 text-sm text-gray-500">
                        Maximum 100 characters.
                    </span>
                </div>
            </div>

            <div class="grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="hero_image_id">Hero Image</x-forms.label>

                    <x-forms.inputs.input name="hero_image_id" :value="$article?->hero_image_id" maxlength="20" placeholder="NoiJZhDF4Es" />

                    @if (($article?->author() ?? auth()->user())->isVerifiedAuthor())
                        <p class="mt-2 text-sm text-gray-600">
                            Because you're a verified author, you're required to choose an <x-a href="https://unsplash.com/s/photos/hello?orientation=landscape" >Unsplash</x-a> image for your article.
                        </p>
                    @else
                        <p class="mt-2 text-sm text-gray-600">
                            Optionally, add an <x-a href="https://unsplash.com/s/photos/hello?orientation=landscape">Unsplash</x-a> image.
                        </p>
                    @endif

                    <p class="mt-2 text-sm text-gray-600">
                        Please enter the Unsplash ID of the image you want to use. <strong>You can find the ID in the URL of the image on Unsplash</strong>. Please make sure to <strong>only use landscape images</strong>. For example, if the URL is <code class="whitespace-nowrap">https://unsplash.com/photos/...-NoiJZhDF4Es</code>, then the ID is <code>NoiJZhDF4Es</code>. After saving your article, the image will be automatically fetched and displayed in the article. This might take a few minutes. If you want to change the image later, you can do so by editing the article before submitting it for approval.
                    </p>
                </div>
            </div>

            <div class="grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="body" />

                    <livewire:editor :body="$article?->body()"/>

                    @error('body')
                </div>
            </div>

            <div class="grow space-y-6">
                <div class="grow space-y-6">
                    <div class="space-y-1">
                        <x-forms.label for="original_url">Original URL</x-forms.label>

                        <x-forms.inputs.input name="original_url" :value="old('original_url', $article?->originalUrl())" />

                        <span class="mt-2 text-sm text-gray-500">
                            If you have already posted this article on your own site, enter the URL here and the content will be attributed to you.
                        </span>
                    </div>
                </div>

                <div class="grow space-y-6">
                    <div class="space-y-1">
                        <x-forms.label for="tags" />

                        <select name="tags[]" id="create-article" multiple x-data="{}" x-init="$nextTick(function () { choices($el) })">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        @error('tags')
                    </div>
                </div>
            </div>

            <div class="md:flex md:items-center md:justify-between">
                <x-info>
                    <span class="font-bold">Note:</span>
                    You can't edit an article anymore after it's been published.
                </x-info>

                <div class="flex justify-end items-center">
                    <a href="{{ isset($article) ? route('articles.show', $article->slug()) : route('user.articles') }}" class="text-lio-700 mr-4">
                        Cancel
                    </a>

                    @if (isset($article) && $article->isSubmitted())
                        <button
                            type="submit"
                            name="submitted"
                            value="1"
                            class="button button-primary"
                        >
                            Save changes
                        </button>
                    @else
                        <span class="relative z-0 inline-flex shadow-xs" x-data="{ showDropdown: false }" @click.outside="showDropdown = false">
                            <button
                                type="submit"
                                name="submitted"
                                value="0"
                                class="button button-primary button-dropdown-left relative inline-flex items-center focus:outline-hidden"
                            >
                                Save draft
                            </button>
                            <span class="-ml-px relative block">
                                <button
                                    @click="showDropdown = !showDropdown"
                                    type="button"
                                    class="button button-primary h-full button-dropdown-right relative inline-flex items-center focus:outline-hidden"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div class="origin-top-right absolute right-0 mt-2 w-60 rounded-md shadow-lg" x-show="showDropdown" x-cloak>
                                    <div class="rounded-md bg-white ring-1 ring-black ring-opacity-5">
                                        <div class="py-1">
                                            <button
                                                type="submit"
                                                name="submitted"
                                                value="1"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-hidden focus:bg-gray-100 focus:text-gray-900 w-full text-left"
                                            >
                                                Save and submit for approval
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </span>
                    @endif
                </div>
            </div>

            @unless (Auth::user()->hasTwitterAccount() && Auth::user()->hasBlueskyAccount())
                <span class="text-gray-600 text-sm mt-4 block">
                    Articles will be shared on X (Twitter).
                    <a href="{{ route('settings.profile') }}" class="text-green-darker">Add your X (Twitter) and/or Bluesky handles</a> and we'll include that too.
                </span>
            @endunless
        </div>
    </div>
</x-forms.form>
