<script setup>
import DataTable from 'datatables.net-vue3'
import { URL } from '../static/global.js'
import dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'
import $ from 'jquery'

dayjs.extend(utc)

const options = {
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

const columns = [
  { data: 'id' },
  { data: 'calldate' },
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

</script>

<template>  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <DataTable
        :columns="columns"
        :ajax="options"
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
.hidden {
  display: none;
}
</style>