@if( Uri::current() == '/' )
<section class="books">
@else
<section class="books-with-border">
@endif

    <div class="words">
        <h1>Laravel Books</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio officiis reprehenderit praesentium quas quo harum dolores magnam voluptate voluptas.</p>
    </div>

    <div class="book">
        <a href="https://leanpub.com/codehappy" target="_blank">
            <img src="{{ URL::to_asset('img/book-laravel-code-happy-dayle-rees.jpg') }}">
            <div class="title">Laravel: Code Happy</div>
            <div class="author">by Dayle Rees</div>
        </a>
    </div>

    <div class="book" target="_blank">
        <a href="http://www.packtpub.com/laravel-php-starter/book">
            <img src="{{ URL::to_asset('img/book-laravel-starter-shawn-mccool.jpg') }}">
            <div class="title">Laravel Starter</div>
            <div class="author">by Shawn McCool</div>
        </a>
    </div>

</section>