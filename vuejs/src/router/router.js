import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthLayout from "../core/components/layout/AuthLayout";
import Login from "../modules/Auth/Login";
import ResetPasswordRequest from "../modules/Auth/ResetPassword/ResetPasswordRequest";
import ResetPasswordForm from "../modules/Auth/ResetPassword/ResetPasswordForm";

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
          name: 'login',
          component: Login,
        },
        {
          path: 'reset-password-request',
          name: 'reset-password-request',
          component: ResetPasswordRequest,
        },
        {
          path: 'reset-password/:token',
          name: 'reset-password',
          component: ResetPasswordForm,
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