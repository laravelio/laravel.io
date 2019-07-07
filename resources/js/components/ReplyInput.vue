<template>
    <textarea class="editor" name="body" placeholder="Write your reply..."></textarea>
</template>

<script>
    import SimpleMDE from 'simplemde';
    import 'simplemde/dist/simplemde.min.css';
    export default {
        mounted() {
            new SimpleMDE({ 
                showIcons: ["code"],
                hideIcons: ['preview', 'side-by-side', 'guide'],
                element: this.$el.querySelectorAll('editor')[0],
                status: false
            });
        }
    }
</script>