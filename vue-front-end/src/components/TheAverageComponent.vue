<script setup>
import DataTable from 'datatables.net-vue3'
import { URL } from '../static/global.js'
import $ from 'jquery'
import dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'

dayjs.extend(utc)

const ajax = {
  url: URL.GET_AVERAGE,
  dataSrc: function (json) {
    let newData = json.data
    newData.map(o => {      
      o.average = dayjs.utc(o.average * 1000).format('HH:mm:ss')
      o.average = o.average === 0 ? '00:00:00' : o.average
    })
    
    return newData
  }
}

const columns = [
  { data: 'date' },
  { data: 'name' },
  { data: 'average' },
]

const options = {
  rowGroup: {
      dataSrc: 'date'
  },
  footerCallback: function() {
    let api = this.api()
    let intVal = function (i) {
      if (typeof i === 'number') {        
        return i
      }
      if (typeof i === 'string') {
        const [hrs, min, sec] = i.split(':')
        return Number(hrs) * 60 * 60 + Number(min) * 60 + Number(sec)
      }
      return 0
    }

    let totalAverage = api
                        .column(2)
                        .data()
                        .reduce(function (a, b) {                            
                            return intVal(a) + intVal(b)
                        }, 0)

    totalAverage = totalAverage / api.column(2).data().length

    totalAverage = dayjs.utc(totalAverage * 1000).format('HH:mm:ss')
    totalAverage = totalAverage === 0 ? '00:00:00' : totalAverage

    $(api.column(0).footer()).html('')
    $(api.column(1).footer()).html('Average')
    $(api.column(2).footer()).html(totalAverage)
  }
} 

</script>

<template>  
  <div class="container">
    <div class="row">
      <div class="col-md-12">        
        <DataTable
        ref="table"
        :columns="columns"
        :ajax="ajax"
        :options="options"
        class="display"
        width="100%">
          <thead>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Average</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Average</th>
            </tr>
          </tfoot>
        </DataTable>
      </div>
    </div>
  </div>
</template>

<style>
@import 'datatables.net-dt';
</style>