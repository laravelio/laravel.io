<template>
    <div class="modal" v-if="show">
        <slot/>
    </div> 
</template>

<script>
    export default {
        props: ['identifier', 'activeModal'],
        computed: {
            show() {
                return this.identifier === this.activeModal
            }
        }
    }
</script>