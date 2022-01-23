@component('mail::message')

Your article: **{{ $article->title() }}** has been deleted from Laravel.io.
See reason from the admin:
{{ $message }}

@endcomponent
