<div class="container mx-auto flex justify-center mt-14">
    <div class="w-full mx-4 text-center">
        <p class="text-base mb-6 md:text-lg md:mb-12">
            We'd like to thank these <x-accent-text>amazing companies</x-accent-text> for supporting us
        </p>

        <div class="mt-6 grid grid-cols-2 gap-y-8 lg:grid-cols-4">
            @foreach (config('sponsors') as $company => $sponsor)
                <div class="col-span-2 flex justify-center lg:col-span-1 {{ $sponsor['offset'] ?? '' }}">
                    <x-sponsor-logo url="{{ $sponsor['url'] }}" logo="{{ asset($sponsor['logo']) }}" company="{{ $company }}" />
                </div>
            @endforeach

        </div>

        <x-ads.cta primary class="mt-8 md:mt-12">
            Your logo here?
        </x-ads.cta>
    </div>
</div>
