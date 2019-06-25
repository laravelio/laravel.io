@if (session()->has('error'))
    <div class="alert alert-danger">
        <div class="flex items-center justify-between container mx-auto px-4">
            {!! session()->pull('error') !!}
            <button type="button" class="close" aria-hidden="true">&times;</button>
        </div>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-primary">
        <div class="flex items-center justify-between container mx-auto px-4">
            {!! session()->pull('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
    </div>
@endif