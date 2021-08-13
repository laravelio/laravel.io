@props(['articles'])

@unless ($articles->count() < 4)
    <div class="flex flex-col gap-y-8 lg:flex-row lg:gap-x-8 lg:mb-16">
        <div class="w-full lg:w-1/3">
            <x-articles.summary 
                :article="$articles->first()"
                is-featured
            />
        </div>

        <div class="w-full lg:w-1/3">
            <x-articles.summary 
                :article="$articles->get(1)"
                is-featured
            />
        </div>

        <div class="w-full flex flex-col gap-y-8 lg:w-1/3">
            <div class="lg:border-b-2 lg:border-gray-200 lg:h-72">
                <x-articles.summary :article="$articles->get(2)" />
            </div>

            <div class="lg:pt-6 flex-1">
                <x-articles.summary :article="$articles->get(3)" />
            </div>
        </div>
    </div>
@endunless