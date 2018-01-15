<template>
<el-container>
  <el-header>
    <el-input v-model="input" placeholder="请输入搜索内容"></el-input>
    <el-button type="primary" icon="el-icon-search">搜索</el-button>
  </el-header>
  <div class="selecter">
    <el-select v-model="value" placeholder="请选择">
       <el-option
         v-for="item in options"
         :key="item.value"
         :label="item.label"
         :value="item.value">
       </el-option>
     </el-select>
     <el-select v-model="value" placeholder="请选择">
        <el-option
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <el-select v-model="value" placeholder="请选择">
         <el-option
           v-for="item in options"
           :key="item.value"
           :label="item.label"
           :value="item.value">
         </el-option>
       </el-select>
  </div>

    <el-main>
      <el-card class="box-card">
        <div v-for="o in 4" :key="o" class="text item" @click="toDetails(o)">

          <div class="item-left">
                <img src="//p1.meituan.net/200.0/deal/ae27f950dd176ffc5b3c56c065e70d8145266.jpg@126_0_388_388a%7C267h_267w_2e_100Q" alt="">
          </div>

          <div class="item-right">
            <div>妙味香美蛙鱼头</div>
            <div>[大千美食街]100元开业劲爆限量抢购券1张</div>
            <div class="price">
              <span>998</span>元
            </div>
          </div>
        </div>
      </el-card>
    </el-main>

</el-container>
</template>

<script>
  export default {
    name:"SelectPage",
    data() {
      return {
        options: [{
          value: '选项1',
          label: '黄金糕'
        }, {
          value: '选项2',
          label: '双皮奶'
        }, {
          value: '选项3',
          label: '蚵仔煎'
        }, {
          value: '选项4',
          label: '龙须面'
        }, {
          value: '选项5',
          label: '北京烤鸭'
        }],
        value: '',
        selectedOptions:[],
        input: ''
      }
    },
    computed:{

    },
    methods:{
      toDetails:function(key){

        this.$store.commit("newPage","asd");
        this.$router.push({path:"/shop/1"})
      }
    }
  }
</script>
<style scoped>
.item{
  display: flex;
  border-bottom:1px solid #DDD8CE;
  padding:10px;
}
.item img{
  width: 80px;
}
.item-right{
  text-align: left;
  padding-left:17px;
}

.el-header,.el-main{
  padding: 0;
}
.selecter{
  margin: 10px 0 10px;
  display: flex;
}
.selecter>div{
  flex: 1;
}
  header{
    display: flex;
    height:unset !important;
  }
  header span{
    flex:1;
    margin-right: 5px;
  }
  header>div{
    flex:1;
      margin-left: 5px;
  }
</style>
