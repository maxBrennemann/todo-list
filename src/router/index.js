import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import Lists from '@/views/Lists.vue'
import Register from '@/views/Register.vue'
import toDoStore from '../store/toDoStore.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/overview',
      name: 'Übersicht',
      component: Lists,
      meta: {
        requiresAuth: true,
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Registrieren',
      component: Register
    },
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!toDoStore.getters.isLoggedIn) {
      next({ name: "Login" })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
