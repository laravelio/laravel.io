function limitTagCheckboxes()
{
    $('.form input[type=checkbox]').change(function() {
        var bol = $("input[type=checkbox]:checked").length >= 3;
        $("input[type=checkbox]").not(":checked").attr("disabled",bol);
    });
}

function moveSidebar()
{
    $( "window" ).bind( "resize", function() {
        if (document.width < '800') {
            $('.sidebar').insertAfter('section.content');
        }
    });
}

limitTagCheckboxes();
moveSidebar();