@component('mail::message')

Great news! Your article: **{{ $title }}** has been approved and is now live on Laravel.io.

@component('mail::button', ['url' => route('articles.show', $slug)])
View Article
@endcomponent

@endcomponent
