<template>
<el-container>
  <JsSdk ref="share"/>


  <el-carousel >
    <el-carousel-item v-for="item in items" :key="item">
      <h3 class="imagH3">
        <img class="loop" :src="item"  alt="">
      </h3>
    </el-carousel-item>
  </el-carousel>
  <el-header>
    <el-input style="margin:0;" v-model="input" placeholder="请输入店家名字进行搜索" @keyup="search">
       <el-button slot="append" icon="el-icon-search" @click.preventDefault="search"></el-button>
     </el-input>
  </el-header>


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
    <img src="static/image/a4.png" @click="filter('小吃')" alt="">
  <span>小吃</span>
</div></el-col>
  <el-col :span="6"><div class="grid-content bg-purple-light">
    <img src="static/image/a3.png" @click="filter('河鲜')" alt="">
    <span>河鲜</span>
  </div></el-col>
</el-row>


    <el-main>
      <div class="op">
        <el-select style="display:none;" size="small" v-model="Foodvalue" placeholder="饮食分类">
          <el-option
            v-for="item in foodOption"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>



        <el-select size="small" v-model="areaValue" placeholder="地域分类">
          <el-option
          style="width:96%;"
            v-for="item in areaOption"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>

        <el-select  size="small" v-model="statsS" placeholder="星级排序">
          <el-option
            v-for="item in starsSorts"
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
            <div>{{o.sname}}</div>
            <div class="block">
              <el-rate disabled aria-valuenow="4" v-model="itemsArray[index].star" ></el-rate>
            </div>
            <div class="area">
              <div class="">
                {{o.address}}

              </div>

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
import JsSdk from '../components/JsSdk'
import { Loading } from 'element-ui';
  export default {
    components:{
      JsSdk
    },
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
        items:[ "static/images/1.jpg","static/images/2.jpg"],
        starsSorts:[
          {
            value:"esc",
            label:"升序"
          },
          {
            value:"desc",
            label:"倒序"
          }
        ],
        statsS:'',

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
        },
        {
            value: '隆昌市',
            label: '隆昌市'
        }, {
          value: '资中县',
          label: '资中县'
        },{
          value: '威远县',
          label: '威远县'
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
        input: '',
        sTimes:false
      }
    },
    watch:{
      statsS:function(v){
          if(v=="desc"){
            this.itemsArray.sort(function(a,b){
                //return a.star-b.star;
                return parseInt(b.star)-parseInt(a.star);//降序
              });
              console.log(  this.itemsArray)
          }else{
            this.itemsArray.sort(function(a,b){
                //return a.star-b.star;
                return parseInt(a.star)-parseInt(b.star);//降序
              });
                console.log(  this.itemsArray)
          }

      },
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
      console.log(this.selectPageArray);
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

          return Sreg.test(v.sname);
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
        let store=this.$store.state.part;

          if(store!='' && !that.sTimes){
            that.sTimes=true;
              that.areaValue=store;
              type=store;
              this.$store.commit("newPart","");
            //地域筛选
          }
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
              for (let x=1;x<=5;x++){
                res.data.msgBox[0]["star"+x]=parseInt(res.data.msgBox[0]["star"+x]);
              }
              res.data.msgBox.map((value,index)=>{
                if(value.pics!=''){
                    res.data.msgBox[index].image=value.pics.split(",")[0];
                }else{
                    res.data.msgBox[index].image="static/image/400.gif";
                }
                if(parseInt(res.data.msgBox[index].views)==0){
                  res.data.msgBox[index].star=0
                }else{
                  res.data.msgBox[index].star=that.nowStar=(5*res.data.msgBox[index].star5+4*res.data.msgBox[index].star4+3*res.data.msgBox[index].star3+2*res.data.msgBox[index].star2+res.data.msgBox[index].star1)/parseInt(res.data.msgBox[index].views);
                }
              })

              let store=this.$store.state.part;

              that.bakArray=that.bakArray.concat(res.data.msgBox);
              that.itemsArray=that.itemsArray.concat(res.data.msgBox);

              //去重
              that.itemsArray.map((v,k)=>{

                that.itemsArray.map((v2,k2)=>{
                  if(v.id==v2.id && k!=k2){
                      that.itemsArray.splice(k,1);
                  }
                })
              })
            }

            if(loadingInstance!=null){
              this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
                   loadingInstance.close();
                    that.itemsLoading=true;
                      that.loaddingText="没有更多";
              });
            }
            setTimeout(()=>{
              if(loadingInstance!=null){
                this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
                     loadingInstance.close();
                      that.itemsLoading=true;
                        that.loaddingText="没有更多";
                });
              }
            },2000)
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

      // JSSDK
      let datesA={
        "title":"甜城味·内江美食地图",
        "desc":"内江史上最全的美食地图,没有之一!",
        "image":"http://weixin.scnjnews.com/foods/share.png",
        "link":"http://weixin.scnjnews.com/foods/#/pickpage",
      }
      this.$refs.share.share(datesA);
      //jssdk
      document.title="大千美食节";
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
          that.loaddingText="loadding....";
          that.itemsLoading=false;
          that.underRequire=true;
          let loadingInstance = Loading.service({
            target:"#Iloading"
          });
          if(that.areaValue!="所有区域"){
              that.getGoodS(loadingInstance,that.areaValue);
          }else{
              that.getGoodS(loadingInstance);
          }

        }
      })

      //
      let dates={
        "act":"getAll"
      }
      this.$http.post("api/frontapi.php",dates).then(res=>{
        for (let x=1;x<=5;x++){
          res.data.msgBox[0]["star"+x]=parseInt(res.data.msgBox[0]["star"+x]);
        }
        res.data.msgBox.map((value,index)=>{
          if(value.pics!=''){
              res.data.msgBox[index].image=value.pics.split(",")[0];
          }else{
              res.data.msgBox[index].image="static/image/400.gif";
          }
          if(parseInt(res.data.msgBox[index].views)==0){
            res.data.msgBox[index].star=0
          }else{
            res.data.msgBox[index].star=that.nowStar=(5*res.data.msgBox[index].star5+4*res.data.msgBox[index].star4+3*res.data.msgBox[index].star3+2*res.data.msgBox[index].star2+res.data.msgBox[index].star1)/parseInt(res.data.msgBox[index].views);
          }
        })

        that.selectPageArray=res.data.msgBox;

      },(e)=>{
        console.log(e)
      })

    }
  }
</script>
<style scoped>


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
.op input{
  width: 96% !important;
margin: 0 auto !important;
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
  height: 100%;
  margin: 0;
}
.loop{
  width: 100%;
  height: 100%;
}
.item{
  display: flex;
  border-bottom:1px solid #DDD8CE;
  padding:10px;
  position: relative;
}
.item img{
  height:80px;
  width: 120px;
}
.area{
  position: absolute;
    left: 73%;
    top: 30%;
    font-size: 14px;
}
.item-right{
  text-align: left;
  font-weight: bold;
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
  .uname{
    text-align: center;
    background: #00adff;
      height: 60px;
      line-height: 60px;
      font-size: 20px;
      font-weight: bold;
      color: #fff;
  }

</style>
