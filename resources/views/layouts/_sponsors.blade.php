<div class="container mx-auto flex justify-center mt-14">
    <div class="w-full mx-4 text-center">
        <p class="text-base mb-6 md:text-lg md:mb-12">
            We'd like to thank these <x-accent-text>amazing companies</x-accent-text> for supporting us
        </p>

        <div class="mt-6 grid grid-cols-2 gap-y-8 lg:grid-cols-4">
            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://beyondco.de" logo="{{ asset('images/sponsors/beyondcode.png') }}" company="Beyond Code" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://devsquad.com" logo="{{ asset('images/sponsors/devsquad.png') }}" company="DevSquad" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://usefathom.com/ref/7A8QGC" logo="{{ asset('images/sponsors/fathom.png') }}" company="Fathom" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://forge.laravel.com/" logo="{{ asset('images/sponsors/forge.png') }}" company="Forge" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://envoyer.io/" logo="{{ asset('images/sponsors/envoyer.png') }}" company="Envoyer" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://blackfire.io/" logo="{{ asset('images/sponsors/blackfire-io.png') }}" company="Blackfire.io" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://akaunting.com/developers?utm_source=Laravelio&utm_medium=Banner&utm_campaign=Developers" logo="{{ asset('images/sponsors/akaunting.png') }}" company="Akaunting" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://larajobs.com" logo="{{ asset('images/sponsors/larajobs.svg') }}" company="LaraJobs" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://ter.li/vj4bxb" logo="{{ asset('images/sponsors/scout-apm.jpg') }}" company="Scout APM" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://www.cloudways.com/en/?id=972670" logo="{{ asset('images/sponsors/cloudways.png') }}" company="Cloudways" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://red-amber.green" logo="{{ asset('images/sponsors/red-amber.green.svg') }}" company="red-amber.green" />
            </div>
        </div>

        <x-ads.cta primary class="mt-8 md:mt-12">
            Your logo here?
        </x-ads.cta>
    </div>
</div>
