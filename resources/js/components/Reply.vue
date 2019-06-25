<template>
    <div class="forum-content">
        <div v-html="content"></div>
    </div>
</template>

<script>
import hljs from "highlight.js";
import "highlight.js/styles/github.css";

export default {
    props: ["content"],
    mounted() {
        this.$el.querySelectorAll("pre code").forEach(block => {
            hljs.highlightBlock(block);
        });
    }
};
</script>
