@unless($hideAds ?? false)
    <div class="container mx-auto px-4">
        @include('layouts._ads._footer')
    </div>
@endif

@include('layouts._sponsors')

<footer id="footer">
    Copyright &copy; 2013 - {{ date('Y') }} Laravel.io
    <span>&bull;</span>
    <a href="{{ route('terms') }}">Terms</a>
    <span>&bull;</span>
    <a href="{{ route('privacy') }}">Privacy</a>
    <span>&bull;</span>
    <a href="https://github.com/laravelio"><i class="fa fa-github"></i></a>
    <a href="https://twitter.com/laravelio"><i class="fa fa-twitter"></i></a>
</footer>
