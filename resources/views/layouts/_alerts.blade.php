@if (session()->has('error'))
    <div class="alert alert-danger" x-data="{}">
        <div class="flex items-center justify-between container mx-auto px-4">
            {!! session()->pull('error') !!}
            <button 
                type="button" 
                class="close" 
                data-dismiss="alert"
                aria-hidden="true" 
                @click="$el.remove()"
            >
                &times;
            </button>
        </div>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-primary" x-data="{}">
        <div class="flex items-center justify-between container mx-auto px-4">
            {!! session()->pull('success') !!}
            <button 
                type="button" 
                class="close" 
                data-dismiss="alert" 
                aria-hidden="true"
                @click="$el.remove()"
            >
                &times;
            </button>
        </div>
    </div>
@endif