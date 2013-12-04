function setTagActiveStatus()
{
    $('._tag_list ._tag').removeClass('active');

    $('._tags ._tag input').each(function() {
        if ($(this).attr("checked")) {
            var name = $(this).parent().find('._name').text();
            $('._tag_list li a[title=' + name + ']').addClass('active');
        }
    });
}

function toggleTag(tagText) {
    var checkbox = $('._tags ._tag[title=' + tagText + '] input');
    if (checkbox.attr('checked')) {
        checkbox.removeAttr('checked');
    } else {
        checkbox.attr('checked', 'checked');
    }
    setTagActiveStatus();
}

function bindTagChooser() {
    $('._tag_list li a._tag').click(function(e) {
        e.preventDefault();
        toggleTag($(this).text());
    });

    setTagActiveStatus();
}

$(function() {
    bindTagChooser();
});