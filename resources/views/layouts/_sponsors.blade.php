<div class="container mx-auto flex justify-center mt-14">
    <div class="w-full mx-4 text-center">
        <p class="text-base mb-6 md:text-lg md:mb-12">
            We'd like to thank these <x-accent-text>amazing companies</x-accent-text> for supporting us
        </p>

        {{-- <div class="mt-6 flex justify-center">
            <x-sponsor-logo size="large" url="https://www.jetbrains.com/phpstorm/laravel/?utm_source=laravel.io&utm_medium=cpc&utm_campaign=phpstorm&utm_content=footer_logo" logo="{{ asset('images/sponsors/phpstorm.svg') }}" company="PhpStorm by Jetbrains" />
        </div> --}}

        <div class="mt-8 flex justify-center">
            <div class="col-span-2 flex justify-center lg:col-span-1 mr-10">
                <x-sponsor-logo size="medium" url="https://eventy.io/?utm_source=Laravel.io&utm_campaign=eventy&utm_medium=advertisement" logo="{{ asset('images/sponsors/eventy.svg') }}" company="Eventy" />
            </div>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-y-8 lg:grid-cols-3">
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
                <x-sponsor-logo size="medium" url="https://beyondco.de" logo="{{ asset('images/sponsors/beyondcode.png') }}" company="Beyond Code" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://www.bairesdev.com/sponsoring-open-source-projects/" logo="{{ asset('images/sponsors/bairesdev.png') }}" company="BairesDev" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://www.n-ix.com/" logo="{{ asset('images/sponsors/n-ix.png') }}" company="N-iX" />
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1">
                <x-sponsor-logo url="https://litslink.com/" logo="{{ asset('images/sponsors/litslink.png') }}" company="Litslink" size="medium" />
            </div>
        </div>

        <x-ads.cta primary class="mt-8 md:mt-12">
            Your logo here?
        </x-ads.cta>
    </div>
</div>
