@if (session()->has('error'))
    <div class="w-full bg-red-500 p-4 text-white" x-data="{}">
        <div class="container mx-auto flex items-center justify-between px-4">
            {!! session()->pull('error') !!}
            <button type="button" class="text-xl" data-dismiss="alert" aria-hidden="true" @click="$root.remove()">&times;</button>
        </div>
    </div>
@endif

@if (session()->has('success'))
    <div class="w-full bg-lio-500 p-4 text-white" x-data="{}">
        <div class="container mx-auto flex flex-wrap items-center justify-between px-4">
            {!! session()->pull('success') !!}

            @if (session()->has('api_token'))
                <x-api-token :token="session()->pull('api_token')" />
            @endif

            <button type="button" class="text-xl" data-dismiss="alert" aria-hidden="true" @click="$root.remove()">&times;</button>
        </div>
    </div>
@endif
