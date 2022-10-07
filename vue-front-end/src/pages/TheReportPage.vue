<script setup>
import DataTable from 'datatables.net-vue3'
import $ from 'jquery'

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
        ajax="http://localhost:8000/api/data"
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