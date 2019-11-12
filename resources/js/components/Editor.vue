<template>
    <div>
        <div class="border-2 border-b-0 rounded-t p-2 bg-gray-200">
            <ul>
                <li>
                    <button
                        v-for="[key, value] of Object.entries(styles)"
                        :key="key"
                        type="button"
                        class="text-gray-600 mr-4 cursor-pointer"
                        @click="handleClick(key)"
                    >
                        <i class="fa" :class="value.class"></i>
                    </button>
                </li>
            </ul>
        </div>
        <textarea
            :name="name"
            :id="id"
            :value="content"
            class="editor rounded-t-none resize-none h-40"
        ></textarea>
    </div>
</template>

<script>
export default {
    props: ["name", "id", "content"],
    data: () => {
        return {
            // Style configuration.
            styles: {
                header: {
                    before: "### ",
                    class: {
                        "fa-header": true
                    }
                },
                bold: {
                    before: "**",
                    after: "**",
                    class: {
                        "fa-bold": true
                    }
                },
                italic: {
                    before: "_",
                    after: "_",
                    class: {
                        "fa-italic": true
                    }
                },
                quote: {
                    before: "> ",
                    class: {
                        "fa-quote-left": true
                    }
                },
                code: {
                    before: "`",
                    after: "`",
                    class: {
                        "fa-code": true
                    }
                },
                link: {
                    before: "[](",
                    after: ")",
                    class: {
                        "fa-link": true
                    }
                },
                image: {
                    before: "![](",
                    after: ")",
                    class: {
                        "fa-file-image-o": true
                    }
                }
            }
        };
    },
    methods: {
        /**
         * Handle the click event of one a style button.
         */
        handleClick(style) {
            const input = this.$el.querySelectorAll("textarea")[0];

            // Get the start and end positions of the current selection.
            const selectionStart = input.selectionStart;
            const selectionEnd = input.selectionEnd;

            // Find the style in the configuration.
            const styleFormat = this.styles[style];

            // Get any prefix and/or suffix characters from the selected style.
            const prefix = styleFormat.before ? styleFormat.before : "";
            const suffix = styleFormat.after ? styleFormat.after : "";

            // Insert the prefix at the relevant position.
            input.value = this.insertCharactersAtPosition(
                input.value,
                prefix,
                selectionStart
            );

            // Insert the suffix at the relevant position.
            input.value = this.insertCharactersAtPosition(
                input.value,
                suffix,
                selectionEnd + prefix.length
            );

            // Reselect the selection and focus the input.
            input.setSelectionRange(
                selectionStart + prefix.length,
                selectionEnd + prefix.length
            );
            input.focus();
        },

        /**
         * Insert one or more characters at a certain position in a string.
         */
        insertCharactersAtPosition(string, character, position) {
            return [
                string.slice(0, position),
                character,
                string.slice(position)
            ].join("");
        }
    }
};
</script>