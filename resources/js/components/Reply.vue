<template>
    <div class="forum-content">
        <slot/>
    </div>
</template>

<script>
    import hljs from 'highlight.js';
    import 'highlight.js/styles/github.css';

    export default {
        mounted() {
            this.$el.querySelectorAll('pre code').forEach(block => {
                hljs.highlightBlock(block);
            });
        }
    }
</script>
