<template>
<el-container>
  <el-header>
    <el-input v-model="input" placeholder="请输入搜索内容"></el-input>
    <el-button type="primary" icon="el-icon-search">搜索</el-button>
  </el-header>

  <el-carousel height="150px">
    <el-carousel-item v-for="item in items" :key="item">
      <h3 class="imagH3">
        <img class="loop" :src="item"  alt="">
      </h3>
    </el-carousel-item>
  </el-carousel>


<!-- types-->

<el-row class="rrw">
  <el-col :span="6">
    <div class="grid-content bg-purple">
      <img src="static/image/a1.png" alt="">
      <span>火锅</span>
    </div>
  </el-col>
  <el-col :span="6"><div class="grid-content bg-purple-light">
    <img src="static/image/a2.png" alt="">
    <span>汤锅</span>
</div>
</el-col>
  <el-col :span="6"><div class="grid-content bg-purple">
    <img src="static/image/a3.png" alt="">
  <span>小吃</span>
</div></el-col>
  <el-col :span="6"><div class="grid-content bg-purple-light">
    <img src="static/image/a4.png" alt="">
    <span>河鲜</span>
  </div></el-col>
</el-row>

<div class="op">
  <el-select size="small" v-model="Foodvalue" placeholder="饮食分类">
    <el-option
      v-for="item in foodOption"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
  </el-select>

  <el-select size="small" v-model="areaValue" placeholder="地域分类">
    <el-option
      v-for="item in areaOption"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
  </el-select>


  <!-- <el-select v-model="value" placeholder="请选择">
    <el-option
      v-for="item in options"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
  </el-select> -->
</div>


    <el-main>
      <el-card class="box-card">
        <div v-for="(o,index) in itemsArray"  class="text item" @click="toDetails(o)">
          <div class="item-left">
                <img src="//p1.meituan.net/200.0/deal/ae27f950dd176ffc5b3c56c065e70d8145266.jpg@126_0_388_388a%7C267h_267w_2e_100Q" alt="">
          </div>
          <div class="item-right">
            <div>妙味香美蛙鱼头</div>
            <div class="block">
              <el-rate disabled aria-valuenow="1" v-model="index"></el-rate>
            </div>
            <div class="area">
              东兴区
            </div>
            <div class="price">
              <span>火锅</span>
            </div>
          </div>
        </div>

      </el-card>

      <div  id="Iloading">
          {{loaddingText}}
      </div>
    </el-main>

</el-container>
</template>

<script>
import { Loading } from 'element-ui';
  export default {
    name:"SelectPage",
    data() {
      return {
        goodsBeginWith:1,
        itemsArray:[],
        itemsLoading:false,
        underRequire:false,
        loaddingText:"",
        arriveBottom:true,
        star:1,
        items:[ "https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2102900165,11904912&fm=200&gp=0.jpg"],
        areaOption: [
          {
          value: '市中区',
          label: '市中区'
        }, {
          value: '东兴区',
          label: '东兴区'
        }, {
          value: '高新区',
          label: '高新区'
        }, {
          value: '经开区',
          label: '经开区'
        }, {
          value: '资中县',
          label: '资中县'
        },{
          value: '威远县',
          label: '威远县'
        },{
            value: '隆昌市',
            label: '隆昌市'
        }],
        foodoptions: [{
          value: '市中区',
          label: '市中区'
        }, {
          value: '东兴区',
          label: '东兴区'
        }, {
          value: '高新区',
          label: '高新区'
        }, {
          value: '经开区',
          label: '经开区'
        }, {
          value: '资中县',
          label: '资中县'
        },{
          value: '威远县',
          label: '威远县'
        },{
            value: '隆昌市',
            label: '隆昌市'
        }],
        foodOption:[
          {
          value: '火锅',
          label: '火锅'
          }, {
          value: '汤锅',
          label: '汤锅'
        },{
         value: '小吃',
         label: '小吃'
       },{
         value: '河鲜',
         label: '河鲜'
       }
      ],

        Foodvalue: '',
        areaValue:'',
        selectedOptions:[],
        input: ''
      }
    },
    computed:{

    },
    methods:{
      getGoodS:function(loadingInstance=null){

        let that=this;
        let dates={
          "act":"getGoods",
          "type":"火锅",
          "beginWith":that.goodsBeginWith
        }
        this.$http.post("/api/frontapi",dates).then((res)=>{
          if(res.data.status==200){
            if(res.data.msgBox.length<10){
              that.loaddingText="没有更多了~"
              that.arriveBottom=false;//不会再次请求数据
            }else{
              that.goodsBeginWith+=9;
              console.log(that.goodsBeginWith);
              that.itemsArray=that.itemsArray.concat(res.data.msgBox);
            }

            if(loadingInstance!=null){
              this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
                   loadingInstance.close();
                    that.itemsLoading=true;
              });
            }
            that.underRequire=false;

          }
        },(e)=>{
          console.log(e)
        })


      },
      toDetails:function(key){
        this.$store.commit("newPage","asd");
        this.$router.push({path:"/shop/1"})
      }
    },
    mounted:function(){
      this.getGoodS();
      let that=this;
      window.addEventListener("scroll",function(x){
        let total=document.body.scrollHeight;
        let domHeight= document.documentElement.clientHeight ;
        let scorllHeight=window.scrollY;
        //一组10个  max20
        //滑动到底部再次加载
        //不能频繁触发

        if(total<=domHeight+scorllHeight && that.arriveBottom && !that.underRequire){
          that.itemsLoading=false;
          that.underRequire=true;
          let loadingInstance = Loading.service({
            target:"#Iloading"
          });
          that.getGoodS(loadingInstance);
        }
      })
    }
  }
</script>
<style scoped>
.op{
  display: flex;

  margin: 5px 0;
  text-align: center;
}
.op>div{
margin: 0px 5px;
  flex: 1;
}
.op input{
border: none;
text-align: center;
}

.el-dropdown-link {
  cursor: pointer;
  color: #409EFF;
}
.el-icon-arrow-down {
  font-size: 12px;
}
.rrw{
  background: white;
}
.rrw img{
  width: 47px;
  display: block;
  margin: 0 auto;
  height: 47px;
}
.rrw div{
  text-align: center;
  padding: 5px 0 5px;
}

.imagH3{
  margin: 0;
}
.loop{
  width: 100%;
  height: 320px;
}
.item{
  display: flex;
  border-bottom:1px solid #DDD8CE;
  padding:10px;
  position: relative;
}
.item img{
  width: 80px;
}
.area{
  position: absolute;
    left: 85%;
    top: 32%;
    font-size: 17px;
}
.item-right{
  text-align: left;
  padding-left:17px;
}
.block{
  padding: 10px 0;
}
.el-header,.el-main{
  padding: 0;
}
#Iloading{
  text-align: center;
background: white;
margin: 10px 0;
height: 40px;
line-height: 40px;
}
#Iloading div div div{
  margin-top: -35px !important;
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
