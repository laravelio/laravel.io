$(document).ready(function(){
	$(".posts article").click(function(){
	     window.location=$(this).find("a").attr("href");
	     return false;
	});
    $("#site-title").fitText(0.35);
});