<div class="space-y-4">
    <input type="hidden" name="hero_image_id" value="{{ $selectedImageId }}">

    <div
        class="relative"
        x-data="{
            open: @entangle('isOpen'),
            resetScroll() {
                this.$nextTick(() => this.$refs.images?.scrollTo({ top: 0 }))
            },
        }"
        x-effect="if (open) resetScroll()"
        @unsplash-images-updated.window="resetScroll()"
        @click.outside="open = false"
    >
        <x-forms.inputs.input
            type="search"
            name="hero_image_search"
            wire:model.live.debounce.500ms="query"
            placeholder="Search landscape photos on Unsplash"
            autocomplete="off"
            prefix-icon="heroicon-o-magnifying-glass"
            @input="open = $event.target.value.trim().length >= {{ $minimumQueryLength }}"
            @focus="open = $event.target.value.trim().length >= {{ $minimumQueryLength }} || {{ count($images) > 0 || $error ? 'true' : 'false' }}"
        />

        <div
            x-cloak
            x-show="open"
            class="absolute left-0 z-20 mt-2 w-full max-w-md overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5"
        >
            <div wire:loading wire:target="query" class="p-4 text-sm text-gray-600">
                Searching Unsplash images...
            </div>

            <div wire:loading.remove wire:target="query">
                @if ($error)
                    <div class="p-4 text-sm text-red-600">
                        {{ $error }}
                    </div>
                @elseif (count($images) > 0)
                    <div x-ref="images" class="scroll-fade grid max-h-72 grid-cols-2 gap-2 overflow-y-auto p-2">
                            @foreach ($images as $image)
                                <div wire:key="unsplash-image-{{ $image['id'] }}" class="overflow-hidden rounded-md border border-gray-200 bg-white transition hover:border-lio-400">
                                    <button
                                        type="button"
                                        wire:click="selectImage('{{ $image['id'] }}')"
                                        class="group block w-full text-left focus:outline-hidden focus:ring-3 focus:ring-lio-200"
                                    >
                                        <img
                                            src="{{ $image['thumb_url'] }}"
                                            alt="Unsplash photo by {{ $image['author_name'] }}"
                                            class="aspect-video w-full object-cover"
                                        >
                                    </button>

                                    <span class="block truncate px-2 py-1 text-xs text-gray-600">
                                        Photo by
                                        <a
                                            href="{{ $this->authorUrl($image['author_url']) }}"
                                            class="font-medium text-lio-700"
                                            target="_blank"
                                            rel="nofollow noopener noreferrer"
                                            @click.stop
                                        >
                                            {{ $image['author_name'] }}
                                        </a>
                                    </span>
                                </div>
                            @endforeach

                            @if ($this->canLoadMore())
                                <div
                                    x-intersect="$wire.loadMore()"
                                    class="col-span-2 h-px"
                                ></div>
                            @endif
                    </div>

                    <p class="border-t border-gray-100 px-3 py-2 text-xs text-gray-500">
                        Photos provided by <a href="{{ $this->unsplashUrl() }}" class="font-medium text-lio-700" target="_blank" rel="nofollow noopener noreferrer">Unsplash</a>.
                    </p>
                @elseif ($hasSearched)
                    <div class="p-4 text-sm text-gray-600">
                        No images found.
                    </div>
                @else
                    <div class="p-4 text-sm text-gray-600">
                        Preparing search...
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($errors->has('hero_image_id'))
        @foreach ($errors->get('hero_image_id') as $error)
            <x-forms.error>{{ $error }}</x-forms.error>
        @endforeach
    @endif

    <div class="space-y-2">
        @if ($isVerifiedAuthor)
            <p class="text-sm text-gray-600">
                Because you're a verified author, you're required to choose an <x-a href="https://unsplash.com/s/photos/hello?orientation=landscape" >Unsplash</x-a> image for your article.
            </p>
        @else
            <p class="text-sm text-gray-600">
                Optionally, add an <x-a href="https://unsplash.com/s/photos/hello?orientation=landscape">Unsplash</x-a> image.
            </p>
        @endif

        <p class="text-sm text-gray-600">
            Search and choose a landscape image from Unsplash. After saving your article, the image will be automatically fetched and displayed in the article. This might take a few minutes. If you want to change the image later, you can do so by editing the article before submitting it for approval.
        </p>
    </div>

    @if ($selectedImage)
        <div class="inline-block overflow-hidden rounded-md border border-gray-200 bg-white">
            <img
                src="{{ $this->previewImageUrl($selectedImage['raw_url'], 400) }}"
                alt="Unsplash photo by {{ $selectedImage['author_name'] }}"
                class="block h-auto max-w-full"
            >

            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <p class="truncate text-sm text-gray-600">
                    Photo by
                    <a href="{{ $this->authorUrl($selectedImage['author_url']) }}" class="font-medium text-lio-700" target="_blank" rel="nofollow noopener noreferrer">
                        {{ $selectedImage['author_name'] }}
                    </a>
                    on <a href="{{ $this->unsplashUrl() }}" class="font-medium text-lio-700" target="_blank" rel="nofollow noopener noreferrer">Unsplash</a>
                </p>

                <button type="button" wire:click="removeImage" class="shrink-0 cursor-pointer text-sm text-lio-700">
                    Remove
                </button>
            </div>
        </div>
    @endif
</div>
