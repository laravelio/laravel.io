<template>
    <div>
        <div>
            <ul>
                <li>
                    <button type="button" @click="handleClick('bold')">
                        <i class="fa fa-bold"></i>
                    </button>
                    <button type="button" @click="handleClick('emphasis')">
                        <i class="fa fa-italic"></i>
                    </button>
                    <button type="button" @click="handleClick">
                        <i class="fa fa-header"></i>
                    </button>
                    <button type="button" @click="handleClick('code')">
                        <i class="fa fa-code"></i>
                    </button>
                </li>
            </ul>
        </div>
        <textarea 
            :name="name" 
            :id="id"
            :value="content"
            class="editor"
        >
        </textarea>
    </div>
</template>

<script>
    export default {
        props: ['name', 'id', 'content'],
        data: () => {
            return {
                styles: {
                    'headings': {
                        'h1': '# ',
                        'h2': '## ',
                        'h3': '### ',
                        'h4': '#### ',
                        'h5': '##### ',
                        'h6': '###### ',
                    },
                    'bold': '**',
                    'emphasis': '_',
                    'code': '```'
                }
            }
        },
        methods: {
            handleClick(style) {
                const input = document.getElementById(this.id);
                let value = input.value;
                const selectionStart = input.selectionStart;
                const selectionEnd = input.selectionEnd;
                const styleCharacter = this.styles[style];

                value = this.insertCharacterAtPosition(value, styleCharacter, selectionStart);
                value = this.insertCharacterAtPosition(value, styleCharacter, selectionEnd + styleCharacter.length);

                input.value = value;
                input.setSelectionRange(selectionStart + styleCharacter.length, selectionEnd + styleCharacter.length);
                input.focus();
            },

            insertCharacterAtPosition(string, character, position) {
                return [string.slice(0, position), character, string.slice(position)].join('');
            }
        }
    }
</script>