@component('mail::message')

Your article: **{{ $article->title() }}** has been deleted from Laravel.io.<br>
Why your post was deleted by the Moderator:<br>
{{ $message }}

@endcomponent
