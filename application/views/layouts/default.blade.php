<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no" >

        <title>{{ $page_title . ' - ' ?: '' }}Laravel.IO</title>

        <link rel="alternate" type="application/rss+xml" title="RSS" href="{{ URL::to('rss') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ URL::to_asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ URL::to_asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::to_asset('css/prettify.css') }}">
        <link href='http://fonts.googleapis.com/css?family=Share:400,700' rel='stylesheet' type='text/css'>

        <script src="{{ URL::to_asset('js/vendor/modernizr-2.6.2.min.js') }}"></script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36064061-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </head>
    <body>

        <div class="social">
            <div class="row">
              <ul>
                    <li><a href="https://twitter.com/LaravelIO" class="twitter" target="_blank">Twitter</a></li>
                    <li><a href="https://github.com/ShawnMcCool/laravel-io" class="github" target="_blank">Github</a></li>
                    <li><a href="{{ URL::to('rss') }}" class="rss" target="_blank">Rss</a></li>
                </ul>
            </div>      
        </div>

         <header>
            <!-- <a id="showhide" href="#"><img src="{{ URL::to_asset('img/mag-glass.png') }}"></a> -->
            <a href="{{ URL::to_action('topics@index') }}"><img src="{{ URL::to_asset('img/laravel-io-logo.png') }}"></a>
        </header>
    
    <section id="holder" class="row clearfix">
        
        <article>
            {{ $content ?: '' }}
        </article>

        <aside>
                @render('layouts._featured_books')
        </aside>

    </section>
 

 <footer>
    <div class="row">
&copy; Laravel-io 2012-2013
    </div>
</footer>
       

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="{{ URL::to_asset('js/plugins.js') }}"></script>
        <script src="{{ URL::to_asset('js/script.js') }}"></script>

        <div id="disqus"></div>
    </body>
</html>
