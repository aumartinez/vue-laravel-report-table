<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-3">
          <a class="navbar-brand" href="#">Navbar Brand</a>
          <button 
          class="navbar-toggler" 
          type="button" 
          data-bs-toggle="collapse" 
          data-bs-target="#navbarNav" 
          aria-controls="navbarNav" 
          aria-expanded="false" 
          aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
              <font-awesome-icon icon="fa-solid fa-bars" />
            </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <RouterLink to="/" 
                class="nav-link">
                  <span>Home</span>
                  <span class="sr-only">(current)</span>
                </RouterLink>                
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>    
  </div>
</template>

<style scoped lang="scss">
</style>
