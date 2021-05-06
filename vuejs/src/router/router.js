import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthLayout from "../core/components/layout/AuthLayout";
import Login from "../modules/Auth/Login";

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'auth',
      redirect: '/login',
      component: AuthLayout,
      meta: {guest: true},
      children: [
        {
          path: 'login',
          name: 'auth.login',
          component: Login,
        },
      ]
    },
    {
      path: '/login',
      redirect: '/auth/login'
    },
  ]
})

export default router;