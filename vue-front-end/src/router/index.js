import { createRouter, createWebHistory } from 'vue-router'
import TheReportPage from '../pages/TheReportPage.vue'

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    }
    return {
      top: 0
    }  
  },
  routes: [
    {
      path: '/',
      name: 'home',
      component: TheReportPage
    }
  ]
})

export default router