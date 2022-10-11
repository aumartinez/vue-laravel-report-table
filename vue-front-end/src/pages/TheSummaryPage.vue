<script setup>
import TheSummaryComponent from '../components/TheSummaryComponent.vue'
import TheAverageComponent from '../components/TheAverageComponent.vue'
</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Summary</h1>
      </div>
    </div>
  </div>

  <TheSummaryComponent />

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <h2>Call average</h2>
      </div>
    </div>
  </div>

  <TheAverageComponent />
</template>

<style>
</style>