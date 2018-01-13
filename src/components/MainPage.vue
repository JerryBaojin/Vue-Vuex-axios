<template>
  <div class="hello">
    {{author}}
    <router-link to="pickpage"> 前往下一页</router-link>
    <el-button type="primary" @click="changeState">主要按钮</el-button>
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  },
  computed:{
    author(){
      return this.$store.state.page
    }
  },
  methods:{
    changeState:function(){
      this.$store.commit("newPage","asd")
    }
  },
  mounted:function(){

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
