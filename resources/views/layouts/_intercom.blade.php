@if (app()->environment('production') && $appId = config('services.intercom.app_id'))
    <script>
        window.intercomSettings = {
            @if (Auth::check())
                user_id: {{ Auth::user()->id() }},
                user_hash: "{{ Auth::user()->intercomHash() }}",
                name: "{{ Auth::user()->name() }}",
                email: "{{ Auth::user()->emailAddress() }}",
                created_at: {{ Auth::user()->createdAt()->timestamp }},

                @if ($githubUsername = Auth::user()->githubUsername())
                    github: "{{ $githubUsername }}",
                @endif
            @endif

            app_id: "{{ $appId }}"
        };
    </script>
    <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/k7e25len';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
@endif
