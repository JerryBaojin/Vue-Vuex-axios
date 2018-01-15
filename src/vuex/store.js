import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);
const store=new Vuex.Store({
  state:{
    page:"pageA",
    shopId:0
  },
  mutations:{
    newPage(state,msg){
      state.page=msg
    },
    newShop(state,msg){
      state.shopId=msg
    }
  }
})

export default store
