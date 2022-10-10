<script setup>
import DataTable from 'datatables.net-vue3'
import { URL } from '../static/global.js'
import $ from 'jquery'

const ajax = {
  url: URL.GET_PIVOT,
}

const columns = [
  { data: 'date' },
  { data: 'name' },
  { data: 'answered' },
  { data: 'busy' },
  { data: 'congestion' },
  { data: 'noanswered' },
]

const options = {
  rowGroup: {
      dataSrc: 'date'
  },
  footerCallback: function() {
    let api = this.api()
    let intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                            i : 0
                  }
 
    let answeredTotal = api
                      .column(2)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b)
                      }, 0)
				
	  let busyTotal = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b)
                    }, 0)
				
    let congestionTotal = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b)
                        }, 0)
                
	  let noansweredTotal = api
                      .column(5)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b)
                      }, 0)
      
    $( api.column(0).footer() ).html('')
    $( api.column(1).footer() ).html('Total')
    $( api.column(2).footer() ).html(answeredTotal)
    $( api.column(3).footer() ).html(busyTotal)
    $( api.column(4).footer() ).html(congestionTotal)
    $( api.column(5).footer() ).html(noansweredTotal)
  }
} 

</script>

<template>  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Summary</h1>
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
              <th>Answered</th>
              <th>Busy</th>
              <th>Congestion</th>
              <th>No Answer</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Date</th>
              <th>Name</th>
              <th>Answered</th>
              <th>Busy</th>
              <th>Congestion</th>
              <th>No Answer</th>
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