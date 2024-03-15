@props(['articles'])

@unless ($articles->count() < 4)
    <div class="flex flex-col gap-y-8 lg:mb-16 lg:flex-row lg:gap-x-8">
        <div class="w-full lg:w-1/3">
            <x-articles.summary :article="$articles->first()" is-featured />
        </div>

        <div class="w-full lg:w-1/3">
            <x-articles.summary :article="$articles->get(1)" is-featured />
        </div>

        <div class="flex w-full flex-col gap-y-8 lg:w-1/3">
            <div class="lg:h-72 lg:border-b-2 lg:border-gray-200">
                <x-articles.summary :article="$articles->get(2)" />
            </div>

            <div class="flex-1 lg:pt-6">
                <x-articles.summary :article="$articles->get(3)" />
            </div>
        </div>
    </div>
@endunless
