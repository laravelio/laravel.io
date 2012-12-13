$(function() {
    // The as-of-yet not utilized drop down nav
	$('#showhide').click(function()
    {
        if($('._tag_dropdown:hidden').length > 0)
        {
            $('._tag_dropdown').slideDown('fast');
        }
        else
        {
            $('._tag_dropdown').slideUp('fast');
		}
	});

    if($('#disqus_thread').length > 0)
    {
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */	
        var disqus_shortname = 'laravelio'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementById('disqus') || document.getElementById('disqus')).appendChild(dsq);
        })();

        (function () {
            var s = document.createElement('script'); s.async = true;
            s.type = 'text/javascript';
            s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
            (document.getElementById('disqus') || document.getElementById('disqus')).appendChild(s);
        }());
    };
});