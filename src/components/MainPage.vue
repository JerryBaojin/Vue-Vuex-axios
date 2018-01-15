<template>
  <div class="">
    <div class="block">
       <span class="demonstration">默认 Hover 指示器触发</span>
       <el-carousel height="150px">
         <el-carousel-item v-for="item in 4" :key="item">
           <h3>{{ item }}</h3>
         </el-carousel-item>
       </el-carousel>
     </div>
     <div class="block">
       <span class="demonstration">Click 指示器触发</span>
       <el-carousel trigger="click" height="150px">
         <el-carousel-item v-for="item in 4" :key="item">
           <h3>{{ item }}</h3>
         </el-carousel-item>
       </el-carousel>
     </div>
        <el-button type="success" @click="next">成功按钮</el-button>
        <el-button type="success" @click="changeState">store</el-button>

        {{test}}
  </div>

</template>

<script>
export default {
  name: 'MainPage',
  data () {
    return {

    }
  },
  computed:{
      test(){
  return  this.$store.state.page
      }
  },
  methods:{
    changeState:function(){
      this.$store.commit("newPage","asd");
      console.log( this.$store.state)
    },
    next:function(){
      this.$router.push({path:'/pickpage'})
    }
  },
  mounted:function(){

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.el-carousel__item h3 {
  color: #475669;
  font-size: 14px;
  opacity: 0.75;
  line-height: 150px;
  margin: 0;
}

.el-carousel__item:nth-child(2n) {
   background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n+1) {
   background-color: #d3dce6;
}
</style>
