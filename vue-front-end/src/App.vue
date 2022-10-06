<script setup>
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import { RouterView } from 'vue-router'
</script>

<template>
  <section>
    <SiteHeader />
  </section>
  <section class="pt-5 pb-5">
    <RouterView />
  </section>
  <section>
    <SiteFooter />
  </section>
</template>

<style lang="scss">
</style>
