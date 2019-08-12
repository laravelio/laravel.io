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
      @select="onSelect"
      @remove="onRemove"
    />
    <slot />
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
  props: [
    "options",
    "initialValue",
    "label",
    "trackBy",
    "max",
    "name",
    "identifier"
  ],
  components: { Multiselect },
  data() {
    return {
      value: this.initialValue ? this.initialValue : [],
      selectElement: null,
      selectOptions: []
    };
  },
  mounted() {
    this.selectElement = document.getElementById(this.identifier);
    this.selectOptions = this.selectElement.options;
  },
  computed: {
    values() {
      return this.value.map(value => {
        return value.id;
      });
    }
  },
  methods: {
    onSelect(selectedOption) {
      this.toggleSelected(selectedOption.id);
    },
    onRemove(removedOption) {
      this.toggleSelected(removedOption.id, false);
    },
    toggleSelected(value, selected = true) {
      Array.from(this.selectOptions).forEach(option => {
        if (option.value == value) {
          option.selected = selected;
        }
      });
    }
  }
};
</script>