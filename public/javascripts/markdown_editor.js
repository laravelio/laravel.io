// Redactor
function bindRedactor() {
    var buttons = ['code', '|', 'bold', 'italic', '|', 'link', '|', 'unorderedlist', 'orderedlist', 'horizontalrule', '|', 'fullscreen'];

    $('._redactor').redactor({
        placeholder: '',
        buttons: buttons,
        buttonsCustom: {
            code: {
                title: 'Code',
                callback: function(buttonName, buttonDOM, buttonObject) {
                    var selectedText = this.getSelectionText();
                    var html = "<code>" + selectedText + "</code>";
                    this.execCommand('inserthtml', html);
                }
            }
        },
        formattingTags: [],
        air: false,
        airButtons:  ['code', '|', 'bold', 'italic', '|', 'link', '|', 'unorderedlist', 'orderedlist', 'horizontalrule'],
        wym: false,
        cleanup: true,
        phpTags: true,
        // tabFocus: true,
        // removeEmptyTags: true,
        pastePlainText: true,
        tabSpaces: 4,
        formattingTags: ['h1', 'h2'],
        changeCallback: function(html) {
            $('input._source').val(html);
        },
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