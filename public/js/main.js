$(function() {
	var open = false;
	$('#showhide').click(function() {
		if(open === false) {
			$('.tags').slideDown('fast');
			open = true;
		} else {
			$('.tags').slideUp('fast');
			open = false;
		}
	});		
});



$(document).ready(function() {

/* Prettyprint _all_ the code */
prettyPrint();

/* We only want to load disqus when we need it */
if($('#disqus_thread').length)
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