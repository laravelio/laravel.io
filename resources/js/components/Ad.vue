<template>
  <div>
    <script2 async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script2>
    <div v-html="content"></div>
    <script2>(adsbygoogle = window.adsbygoogle || []).push({});</script2>
  </div>
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