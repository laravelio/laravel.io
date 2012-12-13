<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ $page_title . ' - ' ?: '' }}Laravel.IO</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no" >
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ URL::to_asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ URL::to_asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::to_asset('css/prettify.css') }}">
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
    	
    	 <div class="tags">
            <div class="row">
                <div class="eight columns">
                    <!-- All tags ever used -->
                    <h5>The magic tag cloud</h5>
                         <ul>
                            <li><a href="#">Tag 342</a></li>
                            <li><a href="#">Tag 342</a></li>
                            <li><a href="#">Tag 342</a></li>
                            <li><a href="#">Tag 342</a></li>
                            <li><a href="#">Tag 342</a></li>
                                
                            </ul>
                        </div>
                
                   <!-- We could either do a search or think of a cool way of displaying all old topics -->
                   <div class="four columns">
                        <h5>Search for topics</h5>
                        <input type="text" placeholder="search..."/>
                    </div>   
            </div>
        </div>
        
         <header class="row">
           <!--<a id="showhide" href="#"><img src="{{ URL::to_asset('img/mag-glass.png') }}"></a>  -->
           <a href="{{ URL::to_action('topics@index') }}"><img src="{{ URL::to_asset('img/laravel-io-logo.png') }}"></a>
        </header>
        
        <article>   
            	
		      {{ $content ?: '' }}
			
		</article>
  
        <footer>
            &copy; 2012 laravel.io
        </footer>      
		
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="{{ URL::to_asset('js/plugins.js') }}"></script>
        <script src="{{ URL::to_asset('js/main.js') }}"></script>
        <div id="disqus"></div>
	</body>
</html>