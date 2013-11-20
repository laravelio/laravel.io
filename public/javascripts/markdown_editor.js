// Redactor
function bindRedactor() {
    var buttons = ['bold', 'italic', '|', 'link', '|', 'unorderedlist', 'orderedlist', 'horizontalrule', '|', 'fullscreen'];

    $('._redactor').redactor({
        buttons: buttons,
        cleanup: true,
        formattingTags: ['h1', 'h2'],
        changeCallback: function(html) {
            $('input._source').val(html);
        }
    });

    $('._source').each(function() {
        var editor = $('textarea._redactor');
        var html = $(this).val();

        editor.redactor('set', html);
    });
}

$(function() {
    bindRedactor();
});