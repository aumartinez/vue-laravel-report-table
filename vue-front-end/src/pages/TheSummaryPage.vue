<script setup>
import TheSummaryComponent from '../components/TheSummaryComponent.vue'
import TheAverageComponent from '../components/TheAverageComponent.vue'
import TheChartComponent from '../components/TheChartComponent.vue'
</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Call summary</h1>
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

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <h2>Latest calls per agent</h2>
      </div>
    </div>
  </div>

  <TheChartComponent />
</template>

<style>
</style>