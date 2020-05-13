<div class="bg-white">
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <p class="text-center text-base leading-6 font-semibold uppercase text-gray-600 tracking-wider">
            We'd like to thank these <strong>amazing companies</strong> for supporting us
        </p>

        <div class="mt-6 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1 px-2">
                <a class="flex items-center" href="https://m.do.co/c/7922b1dff899">
                    <img class="max-h-12" src="{{ asset('images/digitalocean.png') }}" alt="DigitalOcean">
                </a>
            </div>
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1 px-2">
                <a class="flex items-center" href="https://usefathom.com/ref/7A8QGC">
                    <img class="max-h-12" src="{{ asset('images/fathom.png') }}" alt="Fathom">
                </a>
            </div>
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1 px-2">
                <a class="flex items-center" href="https://forge.laravel.com/">
                    <img class="max-h-12" src="{{ asset('images/forge.png') }}" alt="Forge">
                </a>
            </div>
            <div class="col-span-1 flex justify-center md:col-span-3 lg:col-span-1 px-2">
                <a class="flex items-center" href="https://envoyer.io/">
                    <img class="max-h-12" src="{{ asset('images/envoyer.png') }}" alt="Envoyer">
                </a>
            </div>
            <div class="col-span-2 flex justify-center md:col-span-3 lg:col-span-1 px-2">
                <a class="flex items-center" href="https://blackfire.io/">
                    <img class="max-h-12" src="{{ asset('images/blackfire-io.png') }}" alt="Blackfire.io">
                </a>
            </div>
        </div>

        <div class="mt-4">
            @include('layouts._ads._cta', ['text' => 'Your logo here?'])
        </div>
    </div>
</div>
