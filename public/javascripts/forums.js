var tagsDisabled = false;
var maxTags = 3;

function checkForMaximumTags() {
    if ($('._tag_list ._tag.active').length >= maxTags) {
        tagsDisabled = true;

        $('._tag_list ._tag').not('.active').addClass('disabled');
    } else {
        tagsDisabled = false;
        $('._tag_list ._tag.disabled').removeClass('disabled');
    }
}

function setTagActiveStatus() {
    $('._tag_list ._tag').removeClass('active');
    var tagInputs = $('._tags').find('input');
    tagInputs.each(function() {
        var tag = $(this).attr('title');
        if ($(this).attr('checked') == 'checked') {
            $('a._tag[title=' + tag + ']').addClass('active');
        }
    });

    checkForMaximumTags();
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
        if ( ! $(this).hasClass('disabled')) {
            toggleTag($(this).text());
        }
    });

    // set up initial state
    setTagActiveStatus();
}

$(function() {
    bindTagChooser();
});