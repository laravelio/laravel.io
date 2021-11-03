// Handle the click event of the style buttons inside the editor.
window.handleClick = (style, element) => {
    const { styles } = editorConfig();
    const input = element.querySelectorAll('textarea')[0];

    // Get the start and end positions of the current selection.
    const selectionStart = input.selectionStart;
    const selectionEnd = input.selectionEnd;

    // Find the style in the configuration.
    const styleFormat = styles[style];

    // Get any prefix and/or suffix characters from the selected style.
    const prefix = styleFormat.before ? styleFormat.before : '';
    const suffix = styleFormat.after ? styleFormat.after : '';

    // Insert the prefix at the relevant position.
    input.value = insertCharactersAtPosition(input.value, prefix, selectionStart);

    // Insert the suffix at the relevant position.
    input.value = insertCharactersAtPosition(input.value, suffix, selectionEnd + prefix.length);

    // Reselect the selection and focus the input.
    input.setSelectionRange(selectionStart + prefix.length, selectionEnd + prefix.length);
    input.focus();
};

// Insert provided characters at the desired place in a string.
const insertCharactersAtPosition = (string, character, position) => {
    return [string.slice(0, position), character, string.slice(position)].join('');
};

// Configuration object for the text editor.
window.editorConfig = (body) => {
    return {
        styles: {
            header: {
                before: '### ',
            },
            bold: {
                before: '**',
                after: '**',
            },
            italic: {
                before: '_',
                after: '_',
            },
            quote: {
                before: '> ',
            },
            code: {
                before: '`',
                after: '`',
            },
            link: {
                before: '[](',
                after: ')',
            },
            image: {
                before: '![](',
                after: ')',
            },
        },
        body: body,
        mode: 'write',
        submit: function (event) {
            event.target.closest('form').submit();
        },
    };
};

Livewire.on('previewRequested', () => {
    highlightCode(document.getElementById('editor-preview'));
});
