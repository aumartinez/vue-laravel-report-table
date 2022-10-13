import { defineStore } from 'pinia'
import { URL } from '../static/global.js'
import { api } from '../plugins/api.js'

export const vueStore = defineStore({
  id: 'vueStore',
  state: () => ({
    chartLoaded : false,
    latestDate: '',
    chartLabels : [],
    dataAnswered : [],
    dataBusy: [],
    dataCongestion: [],
    dataNoAnswered: []
  }),
  actions: {    
    fetchData () {
      try {
        let res = api.get(URL.GET_DATA)

        res
        .then (res => {
          let labels = []
          let answered = []
          let busy = []
          let congestion = []
          let noanswered = []

          res.data.map((o, i) => {
            labels.push(o.name)
            answered.push(o.answered)
            busy.push(o.busy)
            congestion.push(o.congestion)
            noanswered.push(o.noanswered)
          })

          this.latestDate = res.data[0].date
          this.chartLabels = labels
          this.dataAnswered = answered
          this.dataBusy = busy
          this.dataCongestion = congestion          
          this.dataNoAnswered = noanswered
        })
        .finally(() => {
          this.chartLoaded = true
        })
      } catch (error) {
        console.log(error)
      }
    }
  }
})