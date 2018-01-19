import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);
const store=new Vuex.Store({
  state:{
    part:'',
    page:null,
    shopId:0,
    jssdk:[]
  },
  mutations:{
    newPart(state,msg){
      state.part=msg
    },
    newPage(state,msg){
      state.page=msg
    },
    newShop(state,msg){
      state.shopId=msg
    }
  }
})

export default store
