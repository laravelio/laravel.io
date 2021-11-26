@props([
    'article' => null,
    'route',
    'method' => 'POST',
    'tags',
    'selectedTags' => []
])

<x-buk-form action="{{ route(...$route) }}" :method="$method">
    <div class="bg-gray-100 py-6 px-4 space-y-6 sm:p-6">
        <div>
            <h2 id="create_thread_heading" class="text-lg leading-6 font-medium text-gray-900">
                @if ($article)
                    Update article
                @else
                    Write a new article
                @endif
            </h2>

            <x-forms.info class="px-0">
                Submit your article to the Laravel.io portal. Every article that gets approved will be shared with our 45.000 users and wil be tweeted out on our <a href="https://twitter.com/laravelio" class="text-lio-700 underline">Twitter account</a> which has over 45,000 followers. Feel free to submit as many articles as you like. You can even cross-reference an article on your blog with the original url.
            </x-forms.info>

            <x-forms.info class="px-0">
                After submission for approval, articles are reviewed before being published. No notification of declined articles will be provided. Instead, we encourage to also cross-post articles on your own channel as well.
            </x-forms.info>

            <x-rules-banner />
        </div>

        <div class="flex flex-col space-y-6">
            <div class="flex-grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="title">Title</x-forms.label>

                    <x-forms.inputs.input name="title" :value="old('title', $article?->title())" required maxlength="100" />

                    <span class="mt-2 text-sm text-gray-500">
                        Maximum 100 characters.
                    </span>
                </div>
            </div>

            <div class="flex-grow space-y-6">
                <div class="space-y-1">
                    <x-forms.label for="body">Body</x-forms.label>

                    <livewire:editor :body="$article?->body()"/>

                    @error('body')
                </div>
            </div>

            <div class="flex-grow space-y-6">
                <div class="flex-grow space-y-6">
                    <div class="space-y-1">
                        <x-forms.label for="original_url">Original URL</x-forms.label>

                        <x-forms.inputs.input name="original_url" :value="old('original_url', $article?->originalUrl())" />

                        <span class="mt-2 text-sm text-gray-500">
                            If you have already posted this article on your own site, enter the URL here and the content will be attributed to you.
                        </span>
                    </div>
                </div>

                <div class="flex-grow space-y-6">
                    <div class="space-y-1">
                        <x-forms.label for="tags">Tags</x-forms.label>

                        <select name="tags[]" id="create-article" multiple x-data="{}" x-init="$nextTick(function () { choices($el) })">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" @if(in_array($tag->id, $selectedTags)) selected @endif>{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        @error('tags')
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end">

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
                        <span class="relative z-0 inline-flex shadow-sm" x-data="{ showDropdown: false }" @click.outside="showDropdown = false">
                            <button 
                                type="submit" 
                                name="submitted" 
                                value="0" 
                                class="button button-primary button-dropdown-left relative inline-flex items-center focus:outline-none"
                            >
                                Save draft
                            </button>
                            <span class="-ml-px relative block">
                                <button
                                    @click="showDropdown = !showDropdown"
                                    type="button"
                                    class="button button-primary h-full button-dropdown-right relative inline-flex items-center focus:outline-none"
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
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 w-full text-left"
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

            @unless (Auth::user()->twitter())
                <span class="text-gray-600 text-sm mt-4 block">
                    Articles will be shared on Twitter.
                    <a href="{{ route('settings.profile') }}" class="text-green-darker">Add your Twitter handle</a>
                    and we'll include that too.
                </span>
            @endunless
        </div>
    </div>
</x-buk-form>
