<template>
<el-container>
  <el-header>
    <el-input style="margin:0;" v-model="input" placeholder="请输入搜索内容" @keyup="search">
       <el-button slot="append" icon="el-icon-search" @click.preventDefault="search"></el-button>
     </el-input>
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
    <div class="grid-content bg-purple-light">
    <img src="static/image/a2.png" @click="filter('中餐')" alt="">
    <span>中餐</span>
</div>
</el-col>

  <el-col :span="6" >
    <div class="grid-content bg-purple">
      <img src="static/image/a1.png"  @click="filter('火锅(汤锅)')" alt="">
      <span>火锅(汤锅)</span>
    </div>
  </el-col>

  <el-col :span="6"><div class="grid-content bg-purple">
    <img src="static/image/a3.png" @click="filter('小吃')" alt="">
  <span>小吃</span>
</div></el-col>
  <el-col :span="6"><div class="grid-content bg-purple-light">
    <img src="static/image/a4.png" @click="filter('河鲜')" alt="">
    <span>河鲜</span>
  </div></el-col>
</el-row>




    <el-main>
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
      </div>
      <el-card class="box-card" style="border-top:0;" v-show="itemsArray.length!=0">

        <div v-for="(o,index) in itemsArray"  class="text item" @click="toDetails(o)">

          <div class="item-left">
                <img :src="o.image" alt="">
          </div>
          <div class="item-right">
            <div>{{o.name}}</div>
            <div class="block">
              <el-rate disabled aria-valuenow="4" v-model="itemsArray[index].star" ></el-rate>
            </div>
            <div class="area">
              {{o.address}}
            </div>
            <div class="price">
              <span>{{o.type}}</span>
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
        goodsBeginWith:0,
        selectPageArray:[],
        itemsArray:[],
        bakArray:[],
        itemsLoading:false,
        underRequire:false,
        loaddingText:"没有更多了~",
        arriveBottom:true,
        star:1,
        items:[ "https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2102900165,11904912&fm=200&gp=0.jpg"],
        areaOption: [
          {
          value: '所有区域',
          label: '所有区域'
        },
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

        foodOption:[
          {
          value: '所有分类',
          label: '所有分类'
          },
          {
          value: '中餐',
          label: '中餐'
          }, {
          value: '火锅(汤锅)',
          label: '火锅(汤锅)'
        },{
         value: '小吃',
         label: '小吃'
       },{
         value: '河鲜',
         label: '河鲜'
       }
      ],
      Foodvalue:'',
      areaValue:"",
        selectedOptions:[],
        input: ''
      }
    },
    watch:{
      Foodvalue:function(x){
        if( this.areaValue=='所有区域' && x=="所有分类"){
            this.itemsArray=this.bakArray;
            return false;
        }
        let that=this;
        let tg=false;
        if(this.areaValue=='' || this.areaValue=='所有区域'){
          tg=true;
        }else{
            tg=false;
        }
        if(x=='所有分类' && tg){
            this.itemsArray=this.selectPageArray;
        }else{

          if(tg){
              this.itemsArray=this.selectPageArray.filter((v)=>v.type==x);
          }else{
            if(x=='所有分类'){
                  this.itemsArray=this.selectPageArray.filter((v)=> v.address.match(that.areaValue)!=null);
            }else{
              this.itemsArray=this.selectPageArray.filter((v)=>v.type==x).filter((v)=> v.address.match(that.areaValue)!=null )
            }
          }
        }
      },
      areaValue:function(x){

        let that=this;
        let tg=false;

        if( x=='所有区域' && this.Foodvalue=="所有分类"){
          this.itemsArray=this.bakArray;
          return false;
        }
        if(this.Foodvalue=='' || this.Foodvalue=='所有区域'){
          tg=true;
        }else{
            tg=false;
        }
        if(x=='所有区域'  && tg){
          this.itemsArray=this.selectPageArray
        }else{
          if(tg){
              this.itemsArray=this.selectPageArray.filter((v)=>v.address.match(x)!=null);
          }else{
            if(x=='所有区域'){
                  this.itemsArray=this.selectPageArray.filter((v)=>v.type==that.Foodvalue);
            }else{
                this.itemsArray=this.selectPageArray.filter((v)=>v.type==that.Foodvalue).filter((v)=> v.address.match(x)!=null )
            }
          }
        }
      }
    },
    computed:{

    },
    methods:{
      search:function(){
        let __this=this;
        //serach by uname
        let  Sreg=new RegExp(this.input,'g');

        this.itemsArray=this.bakArray.filter((v)=>{

          return Sreg.test(v.name);
        });
      },
      filter:function(value){
        this.itemsArray=this.selectPageArray.filter((v)=>{
          return v.type==value;
        });
      },
      getGoodS:function(loadingInstance=null,type=null){
        let that=this;
        type==null?type="全部":null;
        let dates={
          "act":"getGoods",
          "type":type,
          "beginWith":that.goodsBeginWith
        }
        this.$http.post("api/frontapi.php",dates).then((res)=>{
          if(res.data.status==200){
            if(res.data.msgBox.length<1){
              that.loaddingText="没有更多了~"
              that.arriveBottom=false;//不会再次请求数据
            }else{
              that.goodsBeginWith+=9;
              res.data.msgBox.map((value,index)=>{
                if(value.pics!=''){
                    res.data.msgBox[index].image=value.pics.split(",")[0];
                }else{
                    res.data.msgBox[index].image="static/image/400.gif";
                }
                res.data.msgBox[index].star=Math.round(value.star/value.views);
              })
              that.bakArray=that.bakArray.concat(res.data.msgBox);
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
        let uuid=key.uid;
        this.$store.commit("newPage",key);
        this.$router.push({path:"/shop/"+uuid})
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

      //
      let dates={
        "act":"getAll"
      }
      this.$http.post("api/frontapi.php",dates).then(res=>{
        res.data.msgBox.map((value,index)=>{
          if(value.pics!=''){
              res.data.msgBox[index].image=value.pics.split(",")[0];
          }else{
              res.data.msgBox[index].image="static/image/400.gif";
          }
          res.data.msgBox[index].star=Math.round(value.star/value.views);
        })
          that.selectPageArray=res.data.msgBox;
      },(e)=>{
        console.log(e)
      })

    }
  }
</script>
<style scoped>
.item-left{
  height: 100px;
  overflow: hidden;
}

.item-left img{
  padding-top: 20%;
}
.rrw:hover {
  cursor: pointer;
}
.op{
  display: flex;
  background: white;
  margin: 0 0;
  text-align: center;
}

.op>div{

  flex: 1;
}
.op .el-input input{

  border-radius: 0px;
}
.el-main{
  overflow: hidden;
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
  height: 150px;
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
    left: 73%;
    top: 30%;
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
    margin: 0 0 5px;
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
