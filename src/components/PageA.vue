<template>
  <div>asd</div>
</template>
<script>
  export default{
    name:"PageA",
    data:(){
      return {
        title:"asd"
      }
    },
    computed:{
      auth(){
        return this.$store.state.page
      }
    },
    methods:{
  
    }
  }
</script>
