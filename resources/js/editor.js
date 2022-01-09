import getCaretCoordinates from 'textarea-caret';

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
        cursorTop: 0,
        cursorLeft: 0,
        cursorPosition: 0,
        body: body,
        mode: 'write',
        showMentions: false,
        search: '',
        submit: function (event) {
            event.target.closest('form').submit();
        },
        updateCursorPosition: function (element, position) {
            const coordinates = getCaretCoordinates(element, position);
            this.cursorTop = coordinates.top + 25 + 'px';
            this.cursorLeft = coordinates.left + 'px';
        },
        updateSearch: function (event) {
            const element = event.target;
            const content = element.value;
            const cursorPosition = element.selectionEnd;
            const matches = event.target.value.match(/@[\w\d]+/g)

            if (!matches) {
                return this.resetSearch();
            }

            const shouldSearch = matches.some(match => {
                const startPosition = content.search(match)
                const endPosition = startPosition + match.length

                if (cursorPosition >= startPosition && cursorPosition <= endPosition) {
                    console.log(this.$wire.users.length);
                    this.updateCursorPosition(event.target, startPosition)
                    this.showMentions = true;
                    this.search = match.slice(1)
                    this.$wire.getUsers(this.search)
                    return true;
                }

                return false;
            })

            if (!shouldSearch) {
                this.resetSearch()
            }
        },
        resetSearch: function () {
            console.log('Resetting');
            this.showMentions = false;
            this.search = '';
        },
        showUserSelect: function () {
            console.log({ show: this.showMentions, total: this.$wire.users.length })
            return this.showMentions && this.$wire.users.length > 0
        },
        selectUser: function (username) {
            let content = this.$refs.editor.value
            const cursorPosition = this.$refs.editor.selectionEnd
            const matches = content.match(/@[\w\d]+/g)

            if (!matches) {
                return;
            }

            matches.forEach(match => {
                const startPosition = content.search(match)
                const endPosition = startPosition + match.length

                if (cursorPosition >= startPosition && cursorPosition <= endPosition) {
                    this.body = content.substring(0, startPosition) + '@' + username + content.substring(endPosition) + ' ';
                    this.$refs.editor.focus()
                    this.resetSearch()
                }
            })
        }
    };
};

Livewire.on('previewRequested', () => {
    highlightCode(document.getElementById('editor-preview'));
});
