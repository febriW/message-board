import { createRouter, createWebHistory } from 'vue-router'
import ListMessage from '@/views/ListMessage.vue'

const routes = [
  {
    path: '/',
    name: 'listMessage',
    component: ListMessage
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes
})

export default router
