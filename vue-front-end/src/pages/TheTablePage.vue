<script setup>
import { ref, onMounted } from 'vue'
import DataTable from 'datatables.net-vue3'
import SearchBuilder from 'datatables.net-searchbuilder'
import DateTime from 'datatables.net-datetime'
import { URL } from '../static/global.js'
import dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'
import $ from 'jquery'

dayjs.extend(utc)

DataTable.use(DateTime)
DataTable.use(SearchBuilder)

const ajax = {
  url: URL.GET_API,
  dataSrc: function (json) {
    let newData = json.data
    newData.map(o => {      
      o.duration = dayjs.utc(o.duration * 1000).format('HH:mm:ss')
      o.duration = o.duration === 0 ? '00:00:00' : o.duration
    })
    
    return newData
  }
}

const options = {
  dom: 'Qfrtip'
}

const columns = [
  { data: 'id' },
  { data: 'calldate',
    type: 'date' },
  { data: 'cnam' },
  { data: 'dst' },
  { data: 'dcontext' },
  { data: 'disposition' },
  { data: 'duration' },
  { data: 'created_at',
    visible: false ,
  },
  { data: 'updated_at',
    visible: false, 
  },
]

let dt
const table = ref()

onMounted(() => {  
  dt = table.value.dt()
})

</script>

<template>  
  <div class="container">
    <form>
      <div class="row">

      </div>
    </form>    
    <div class="row">
      <div class="col-md-12">        
        <DataTable
        ref="table"
        id="record-list"
        :columns="columns"
        :ajax="ajax"
        :options="options"
        class="display"
        width="100%"
        >
          <thead>
            <tr>
              <th>id</th>
              <th>calldate</th>
              <th>cnam</th>
              <th>dst</th>
              <th>dcontext</th>
              <th>disposition</th>
              <th>duration</th>
              <th class="hidden">created_at</th>
              <th class="hidden">updated_at</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>id</th>
              <th>calldate</th>
              <th>cnam</th>
              <th>dst</th>
              <th>dcontext</th>
              <th>disposition</th>
              <th>duration</th>
              <th class="hidden">created_at</th>
              <th class="hidden">updated_at</th>
            </tr>
          </tfoot>
        </DataTable>
      </div>
    </div>
  </div>
</template>

<style>
@import 'datatables.net-dt';
@import 'datatables.net-searchbuilder-dt';
@import 'datatables.net-datetime';

.hidden {
  display: none;
}

.btn-long {
  width: 100%;
}
</style>