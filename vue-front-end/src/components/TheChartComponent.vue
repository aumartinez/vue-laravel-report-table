<script setup>
import { vueStore } from '../stores/store.js'
import { computed } from 'vue'
import { Bar } from 'vue-chartjs'
import { 
  Chart as ChartJS, 
  Title, 
  Tooltip, 
  Legend, 
  BarElement, 
  CategoryScale, 
  LinearScale 
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const store = vueStore()
store.fetchData()

let chartOptions = {
  responsive: true,
  maintainAspectRatio: false
}

let chartData = computed(() => {
  let data = {
    labels: store.chartLabels,
      datasets: [
        {
          label: 'Answered',
          backgroundColor: '#E0BBE4',
          data: store.dataAnswered
        },
        {
          label: 'Busy',
          backgroundColor: '#957DAD',
          data: store.dataBusy
        },
        {
          label: 'Congestion',
          backgroundColor: '#D291BC',
          data: store.dataCongestion
        },
        {
          label: 'No answered',
          backgroundColor: '#FEC8D8',
          data: store.dataNoAnswered
        }
      ]
  }
  return data  
})

</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p>{{store.latestDate}}</p>
      </div>
      <div class="col-md-12">
        <Bar        
        v-if="store.chartLoaded"
        :chart-options="chartOptions"
        :chart-data="chartData"
        />
      </div>
    </div>
  </div>  
</template>

<style>
</style>