function setTagActiveStatus() {
    $('._tag_list ._tag').removeClass('active');
    var tagInputs = $('._tags').find('input');
    tagInputs.each(function() {
        var tag = $(this).attr('title');
        if ($(this).attr('checked') == 'checked') {
            $('a._tag[title=' + tag + ']').addClass('active');
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
    // each click of a tag link togs the tag
    $('a._tag').click(function(e) {
        e.preventDefault();
        toggleTag($(this).text());
    });

    // set up initial state
    setTagActiveStatus();
}

$(function() {
    bindTagChooser();
});