<template>
  <div v-html="content"></div>
</template>

<script>
export default {
  props: ["identifier"],
  data() {
    return {
      content: ""
    };
  },
  mounted() {
    this.content = document.getElementById(this.identifier).innerHTML;
  }
};
</script>