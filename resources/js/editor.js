import getCaretCoordinates from 'textarea-caret';

// Configuration object for the text editor.
window.editorConfig = (body, hasMentions) => {
    return {
        styles: {
            singleLine: {
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
            multipleLines: {
                code: {
                    before: '```\n',
                    after: '\n```',
                },
            },
        },
        cursorTop: 0,
        cursorLeft: 0,
        body: body,
        hasMentions: hasMentions,
        showMentions: false,
        mentionRegex: /@[a-z\d]*(?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)/g,
        mode: 'write',
        search: '',

        // Gets the current cursor position.
        cursorPosition: function () {
            return this.$refs.editor.selectionEnd;
        },

        // Submits the form enclosing the editor.
        submit: function () {
            this.$dispatch('submitted', this.body);
            this.$wire.emitUp('submitted', this.body);
        },

        // Updates the position of the listbox by calculating the caret position and applying an offset.
        updateListboxPosition: function (element, position) {
            const coordinates = getCaretCoordinates(element, position);
            this.cursorTop = coordinates.top + 25 + 'px';
            this.cursorLeft = coordinates.left + 'px';
        },

        // Takes the user input, determines if a mention is active and initiates the search.
        updateUserSearch: function (event) {
            if (!this.hasMentions) {
                return;
            }

            if (this.isEscapeKey(event.keyCode)) {
                return;
            }

            if (this.isArrowKey(event.keyCode)) {
                return;
            }

            const mentions = this.extractMentions();

            if (!mentions) {
                return this.resetUserSearch();
            }

            const shouldSearch = mentions.some(({ mention, start, end }) => {
                if (this.isAtCursor(start, end)) {
                    this.updateListboxPosition(this.$refs.editor, start);
                    this.showMentions = true;
                    this.search = mention.slice(1);
                    this.$wire.getUsers(this.search);
                    return true;
                }

                return false;
            });

            if (!shouldSearch) {
                this.resetUserSearch();
            }
        },

        // Resets the user search parameters.
        resetUserSearch: function () {
            this.showMentions = false;
            this.search = '';
        },

        // Determines whether or not the user listbox should be rendered.
        showUserListbox: function () {
            return this.showMentions && this.$wire.users.length > 0;
        },

        // Get the currently highlighted user in the listbox.
        getHighlightedUser: function () {
            if (!this.showUserListbox()) {
                return false;
            }

            const highlighted = this.$refs.users.querySelectorAll('li[aria-selected=true]');

            return highlighted[0] ? highlighted[0] : false;
        },

        // Highlight the next user in the listbox.
        highlightNextUser: function (event) {
            const highlighted = this.getHighlightedUser();

            if (!highlighted) {
                return;
            }

            const next = highlighted.nextElementSibling;

            if (!next) {
                return;
            }

            event.preventDefault();

            highlighted.setAttribute('aria-selected', false);
            next.setAttribute('aria-selected', true);
        },

        // Highlight the previous user in the listbox.
        highlightPreviousUser: function (event) {
            const highlighted = this.getHighlightedUser();

            if (!highlighted) {
                return;
            }

            const previous = highlighted.previousElementSibling;

            if (!previous) {
                return;
            }

            event.preventDefault();

            highlighted.setAttribute('aria-selected', false);
            previous.setAttribute('aria-selected', true);
        },

        // Take the selected user and put the name into the editor.
        selectHighlightedUser: function (event) {
            const highlighted = this.getHighlightedUser();

            if (!highlighted) {
                return;
            }

            event.preventDefault();

            this.selectUser(highlighted.dataset.username);
        },

        // Takes the selected user from the listbox and populates the value in the correct place in the editor.
        selectUser: function (username) {
            const mentions = this.extractMentions();

            if (!mentions) {
                return;
            }
            const editor = this.$refs.editor;

            mentions.forEach(({ start, end }) => {
                if (this.isAtCursor(start, end)) {
                    this.body = this.body.substring(0, start) + '@' + username + this.body.substring(end) + ' ';
                    this.resetUserSearch();
                    this.$nextTick(() => {
                        editor.focus();
                        editor.setSelectionRange(start + username.length + 2, start + username.length + 2);
                    });
                }
            });
        },

        // Extracts all the mentions from the input along with their start and end position in the string.
        extractMentions: function () {
            let mention;
            let mentions = [];
            while ((mention = this.mentionRegex.exec(this.body)) !== null) {
                mentions.push({
                    mention: mention[0],
                    start: mention.index,
                    end: mention.index + mention[0].length,
                });
            }

            return mentions;
        },

        // Detects whether or not the provided start and end position overlap the current cursor position.
        isAtCursor: function (start, end) {
            return this.cursorPosition() >= start && this.cursorPosition() <= end;
        },

        // Detects whether or not the given key code is an up or down arrow.
        isArrowKey: function (code) {
            return code == 38 || code == 40;
        },

        // Detects whether or not the given key code is they escape key.
        isEscapeKey: function (code) {
            return code == 27;
        },

        // Handle the click event of the style buttons inside the editor.
        handleClick: function (style) {
            const editor = this.$refs.editor;
            let value = editor.value;
            let styleFormat;

            // Get the start and end positions of the current selection.
            const selectionStart = editor.selectionStart;
            const selectionEnd = editor.selectionEnd;
            const selectedText = value.slice(selectionStart, selectionEnd);
            const hasMultipleLines = new RegExp(/\n/g).test(selectedText);

            // Find the style in the configuration.
            if (hasMultipleLines && this.styles['multipleLines'][style]) {
                styleFormat = this.styles['multipleLines'][style];
            } else {
                styleFormat = this.styles['singleLine'][style];
            }

            // Get any prefix and/or suffix characters from the selected style.
            const prefix = styleFormat.before ? styleFormat.before : '';
            const suffix = styleFormat.after ? styleFormat.after : '';

            // Insert the prefix at the relevant position.
            value = this.insertCharactersAtPosition(value, prefix, selectionStart);

            // Insert the suffix at the relevant position.
            value = this.insertCharactersAtPosition(value, suffix, selectionEnd + prefix.length);

            this.body = value;

            // Reselect the selection and focus the input.
            this.$nextTick(() => {
                this.$refs.editor.focus();
                this.$refs.editor.setSelectionRange(selectionStart + prefix.length, selectionEnd + prefix.length);
            });
        },

        // Insert provided characters at the desired place in a string.
        insertCharactersAtPosition: (string, character, position) => {
            return [string.slice(0, position), character, string.slice(position)].join('');
        },
    };
};

Livewire.on('previewRequested', () => {
    highlightCode(document.getElementById('editor-preview'));
});
