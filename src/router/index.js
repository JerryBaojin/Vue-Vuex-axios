import Vue from 'vue'
import Router from 'vue-router'
import MainPage from '@/components/MainPage'
import SelectPage from '@/components/SelectPage'
import ShopDetails from '@/components/ShopDetails'
import SignIn from '@/components/SignIn'
import AdminTable from '@/components/AdminTable'

Vue.use(Router)

export default new Router({

  routes: [
    {
      path: '/',
      name: 'MainPage',
      component: MainPage
    },
    {
      path: '/pickpage',
      name:"pickpage",
      component:SelectPage

    },{
      path: '/shop/:id',
      name: 'shop',
      component: ShopDetails
    },
    {
      path: '/SignIn',
      name: 'SignIn',
      component: SignIn
    },
    {
      path: '/Sadmin',
      name: 'AdminTable',
      component: AdminTable
    },
  ]
})
