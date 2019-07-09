<template>
    <div>
        <multiselect 
            v-model="value"
            :options="options"
            :label="label"
            :track-by="trackBy"
            :max="max"
            :multiple="true" 
            :close-on-select="false" 
            :clear-on-select="false" 
            :preserve-search="true"
        />
        <input 
            v-for="value in values" 
            type="hidden" 
            :name="name" 
            :value="value" 
            :key="value"
        />
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import 'vue-multiselect/dist/vue-multiselect.min.css';

    export default {
        props: ['options', 'initialValue', 'label', 'trackBy', 'max', 'name'],
        components: { Multiselect },
        data() {
            return {
                value: this.initialValue ? this.initialValue : []
            }
        },
        computed: {
            values() {
                return this.value.map(value => { return value.id })
            }
        }
    }
</script>