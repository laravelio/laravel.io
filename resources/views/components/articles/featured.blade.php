@props(['articles'])

@unless ($articles->count() < 4)
    <div class="flex flex-col lg:flex-row lg:gap-x-8 lg:mb-16">
        <div class="w-full lg:w-1/3">
            <x-articles.summary 
                image="https://images.unsplash.com/photo-1541280910158-c4e14f9c94a3?auto=format&fit=crop&w=1000&q=80" 
                :article="$articles->first()"
                is-featured
            />
        </div>

        <div class="w-full lg:w-1/3">
            <x-articles.summary 
                image="https://images.unsplash.com/photo-1584824486516-0555a07fc511?auto=format&fit=crop&w=1000&q=80" 
                :article="$articles->get(1)"
                is-featured
            />
        </div>

        <div class="w-full lg:w-1/3 flex flex-col">
            <div class="lg:border-b-2 lg:border-gray-200 lg:h-72">
                <x-articles.summary :article="$articles->get(2)" />
            </div>

            <div class="lg:pt-6 flex-1">
                <x-articles.summary :article="$articles->get(3)" />
            </div>
        </div>
    </div>
@endunless