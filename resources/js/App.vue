<template>
    <router-view />
</template>

<script>
export default {
  mounted(){

  },
   watch: {
      '$route' (to, from) {
        document.title = to.meta.title || 'Home'
      }
    },
}
</script>

<style lang="scss">
    .sr-only {
        display: none;
    }
    html {
        scroll-behavior: smooth;
    }
</style>
