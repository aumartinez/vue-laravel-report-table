import { createRouter, createWebHistory } from 'vue-router'
import TheSummaryPage from '../pages/TheSummaryPage.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'summary',
      component: TheSummaryPage
    },
    {
      path: '/table',
      name: 'table',
      component: () => import('../pages/TheTablePage.vue')
    },
  ]
})

export default router