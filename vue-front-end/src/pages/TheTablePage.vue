<script setup>
import { ref, onMounted, computed } from 'vue'
import DataTable from 'datatables.net-vue3'
import DateTime from 'datatables.net-datetime'
import { URL } from '../static/global.js'
import dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'
import $ from 'jquery'

dayjs.extend(utc)

DataTable.use(DateTime)

let ajax = {
  url: URL.GET_API,
  dataSrc: function (json) {
    let newData = json.data
    newData.map(o => {      
      o.duration = dayjs.utc(o.duration * 1000).format('HH:mm:ss')
      o.duration = o.duration === 0 ? '00:00:00' : o.duration
    })
    
    return newData
  },
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
const table = ref(null)

function searchDate() {
  dt = table.value.dt()

  let min = dayjs($('#to').val())
  let max = dayjs($('#from').val())

  let o = dt.data()

  let filtered = o.filter((o, i) => {
    let cDate = dayjs(o.calldate)
    if (!min.isValid() || !max.isValid()) {
      return true
    }

    if (cDate.isValid()) {
      if (min.isBefore(cDate) && cDate.isBefore(max)) {
        return true
      }
    }
  })
  
  dt.clear().rows.add(filtered).draw()  
}

function clearData () {
  dt = table.value.dt()
  dt.ajax.url(URL.GET_API).load()
  dt.search('').draw()
}

onMounted(() => {
  $('input').on('change', function(){
    dt = table.value.dt()
    dt.ajax.url(URL.GET_API).load()
  })
})

</script>

<template>  
  <div class="container">
    <form>
      <div class="row mb-5">
        <div class="col-md-3">
          <label class="form-label" for="to">To:</label>
          <input type="date" class="form-control" id="to" />
        </div>
        <div class="col-md-3">
          <label class="form-label" for="from">From:</label>
          <input type="date" class="form-control" id="from" />
        </div>
        <div class="col-md-3 align-self-end">
          <button
          ref="button"
          @click="searchDate()"
          class="btn btn-primary w-100"
          type="button">
            Search
          </button>          
        </div>
        <div class="col-md-3 align-self-end">
          <button 
          @click="clearData()"
          class="btn btn-primary w-100" type="reset">
            Clear
          </button>
        </div>
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