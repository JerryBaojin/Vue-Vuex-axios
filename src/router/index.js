import Vue from 'vue'
import Router from 'vue-router'
import MainPage from '@/components/MainPage'
import SelectPage from '@/components/SelectPage'

Vue.use(Router)

export default new Router({
  mode:"history",
  routes: [
    {
      path: '/',
      name: 'MainPage',
      component: MainPage
    },
    {
      path: '/pickpage',
      name: 'SelectPage',
      component: SelectPage
    }
  ]
})
