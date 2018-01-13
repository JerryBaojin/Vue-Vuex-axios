// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import ElementUi from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import Vuex from './vuex/store'
import store from './vuex/store'

Vue.use(ElementUi)
Vue.use(Vuex)
Vue.config.productionTip = true

/* eslint-disable no-new */
new Vue({

  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
