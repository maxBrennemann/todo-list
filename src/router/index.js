import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import App from '../App.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: '',
      component: App,
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
  ]
})

export default router
