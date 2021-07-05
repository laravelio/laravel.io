<form action="{{ route(...$route) }}" method="POST" x-data="{ showAdvanced: false }">
    @csrf
    @method($method ?? 'POST')

    <div class="px-4 pt-4">
        @formGroup('title')
            <label for="title">Title</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                value="{{ old('title', isset($article) ? $article->title() : null) }}" 
                class="form-control" 
                required maxlength="100" 
            />
            <span class="text-gray-600 text-sm mt-1">Maximum 100 characters.</span>
            @error('title')
        @endFormGroup

        @formGroup('body')
            <label for="body">Body</label>

            @include('_partials._editor', [
                'content' => isset($article) ? $article->body() : null
            ])
            
            @error('body')
        @endFormGroup
    </div>

    <div x-show="showAdvanced" x-cloak class="px-4 pt-4 border-t-2">
        @formGroup('original_url')
            <label for="original_url">Original URL</label>
            <input 
                type="text" 
                name="original_url" 
                id="original_url" 
                value="{{ old('original_url', isset($article) ? $article->originalUrl() : null) }}" 
                class="form-control" 
            />
            <span class="text-gray-600 text-sm mt-1">If you have already posted this article on your own site, enter the URL here and the content will be attributed to you.</span>
            @error('original_url')
        @endFormGroup

        @formGroup('tags')
            <label for="tags">Tags</label>

            <select name="tags[]" id="create-article" multiple x-data="{}" x-init="function () { choices($el) }">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @if(in_array($tag->id, $selectedTags)) selected @endif>{{ $tag->name }}</option>
                @endforeach
            </select>

            @error('tags')
        @endFormGroup
    </div>

    <div class="px-4 pb-4">
        <button 
            type="button" 
            class="text-lio-700" 
            @click="showAdvanced = !showAdvanced" 
            x-text="showAdvanced ? 'Hide advanced options' : 'Show advanced options'"
        ></button>

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
                <span class="relative z-0 inline-flex shadow-sm" x-data="{ showDropdown: false }" @click.away="showDropdown = false">
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
                        <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg" x-show="showDropdown" x-cloak>
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

        @unless (Auth::user()->twitter())
            <span class="text-gray-600 text-sm mt-4 block">
                Articles will be shared on Twitter. 
                <a href="{{ route('settings.profile') }}" class="text-green-darker">Add your Twitter handle</a> 
                and we'll include that too.
            </span>
        @endunless
    </div>
</form>
