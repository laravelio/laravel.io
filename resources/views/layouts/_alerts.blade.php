@if (session()->has('error'))
    <div class="w-full text-white p-4 bg-red-500" x-data="{}">
        <div class="flex items-center justify-between container mx-auto px-4">
            {!! session()->pull('error') !!}
            <button 
                type="button" 
                class="text-xl"
                data-dismiss="alert"
                aria-hidden="true" 
                @click="$root.remove()"
            >
                &times;
            </button>
        </div>
    </div>
@endif

@if (session()->has('success'))
    <div class="w-full text-white bg-lio-500 p-4" x-data="{}">
        <div class="flex items-center justify-between container mx-auto px-4">
            {!! session()->pull('success') !!}
            <button 
                type="button" 
                class="text-xl"
                data-dismiss="alert" 
                aria-hidden="true"
                @click="$root.remove()"
            >
                &times;
            </button>
        </div>
    </div>
@endif
