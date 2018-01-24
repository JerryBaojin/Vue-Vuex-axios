<template>
  <div class="am-g">
        <JsSdk ref="share"/>
    <div class="uname">
              {{dates.sname}}</h3>
    </div>
    <div class="banner" style="display:none;">
          <div class="block">
           <el-carousel height="240px" style="overflow:hidden;">
             <el-carousel-item v-for="item of dates.image" :key="item">
               <h3>    <img :src="item" class="am-img-responsive" alt="" /></h3>
             </el-carousel-item>
           </el-carousel>
         </div>
    </div>
    <div class="col-sm-12" style="background:white;margin-top:-23px;">
      <h1 class="am-text-center">{{dates.uname}}</h1>

      <div class=" stars">
        <div class="left-box">
          <div class="am-u-sm-3 " style="padding:0;">综合评价</div>
          <div >
            <el-rate
              v-model="nowStar"
              disabled

              void-color=""
              text-color="#ff9900"
          >
            </el-rate>
            热度:{{dates.views}}
          </div>
        </div>

        <div class="right-box">
          <span>
            <div class="">
              惊喜
            </div>
            <el-rate
              v-model="star5"
              disabled
              void-color=""
                >
            </el-rate>
              {{dates.star5}}
          </span>
          <span>
            <div class="">
              满意
            </div>
            <el-rate
              v-model="star4"
              disabled
              void-color=""
                >
            </el-rate>
              {{dates.star4}}
          </span>
          <span>
            <div class="">
              一般
            </div>
            <el-rate
              v-model="star3"
              disabled

              void-color=""
                >
            </el-rate>
              {{dates.star3}}
          </span>
          <span>
            <div class="">
              失望
            </div>
            <el-rate
              v-model="star2"
              disabled

              void-color=""
                >
            </el-rate>
              {{dates.star2}}
          </span>
          <span>
            <div class="">
              极差
            </div>
            <el-rate
              v-model="star1"
              disabled

              void-color=""
                >
            </el-rate>
              {{dates.star1}}
          </span>
        </div>

      </div>


      <hr />
      <div class="am-margin-horizontal-lg details">

        <h3>地址：<small><a style="font-size:16px;" href="javascript:void(0)" @click="toDetialsMap">{{dates.detailsAddr}}</a></small></h3>

        <h3>电话：<small><a :href="'tel:'+dates.phone" >{{dates.phone}}</a></small></h3>
        <h3>类型：<small>{{dates.type}}</small></h3>
        <h3>简介：
            <div class="tip am-margin-horizontal-lg">
              <p>{{dates.info}}</p>
            </div>
          </h3>
          <h4 class="am-margin-horizontal-lg  bigStar" v-if="ableToComments">点击评价：
            <el-rate  @change="change"  :disabled="ableComments"  aria-valuenow="1" v-model="commentStar" ></el-rate>
          </h4>
        <div class="">
          <div v-for="(item,index) of dates.image" :key="item">
            <h3>    <img :src="item" style="width:80%;" class="am-img-responsive" alt="" />
              <div class="inShort">
                {{dates.shortInfos[index]}}
              </div>
            </h3>
          </div>
        </div>
      </div>



      <hr />

    </div>
    <div class="am-topbar-fixed-bottom am-margin-horizontal-sm am-margin-bottom-sm" style="display:none;">
      <button type="button" class="am-btn am-btn-warning am-btn-block">优惠券</button>
    </div>

  </div>
</template>
<script>
import { Loading } from 'element-ui';
import JsSdk from '../components/JsSdk'
  export default{
    components:{
      JsSdk
    },
    name:"ShopDetails",
    data(){
      return {
        star5:5,
        star4:4,
        star3:3,
        star2:2,
        star1:1,
        commentStar:3,
        ableComments:false,
        nowStar:0,
        ableToComments:true,
        dates:''
      }
    },
    computed:{
    },
    methods:{
      toDetialsMap:function(){
      let target=this.$route.params.id;
      this.$router.push({path:"/DetailsMap/"+target})
      },
      change:function(e){
        let openid=localStorage.getItem("openid")|| "null";
        let times=this.dates['uid'];
        let that=this;


        //localStorege
      this.$confirm('确认评论吗？').then(()=>{

                if(openid=='null'){
                  location.href="http://weixin.scnjnews.com/foods/main.php?act=comment&pid="+that.$route.params.id;
                  return false;
                }



            this.$http.post("api/frontapi.php",{"act":"makeComments","openid":openid,"uid":times,"star":e}).then(res=>{
            switch (res.data.status) {
              case 304:
                //location.href="main.php";
                    location.href="http://weixin.scnjnews.com/foods/main.php?act=comment&pid="+that.$route.params.id;
                break;
                case 303:
                    this.$message("之前已经评论过了!");
                      that.ableComments=true;
                  break;
                  case 200:
                      this.$message("评价成功!");
                        that.ableComments=true;
                        localStorage.setItem("zanTimes",1);
                    break;
              default:
            }
            },(e)=>{
              console.log(e)
            })

        })
        .catch(e=>{
          console.log(e)
        })
      }
    },
    mounted:function(){


      let loadingInstance1 = Loading.service({ fullscreen: true });
      let that=this;
      let openid=localStorage.getItem("openid") || "null";

      this.$http.post("api/frontapi.php",{"act":"getOneDetails","uid":this.$route.params,"openid":openid}).then((res)=>{
        console.log(res.data);  if(res.data.hasOwnProperty("tem")){

                //  this.$message('请在微信端登陆后才能评价!');
        }
        if(res.data.status==200){
          if(res.data.time==303){
              that.ableToComments=false;
          }
          res.data.msgBox[0].shortInfos=JSON.parse(res.data.msgBox[0].shortInfos);

          //设置title
          document.title= res.data.msgBox[0].sname;
            if(res.data.msgBox[0].pics!=''){
                res.data.msgBox[0].image=res.data.msgBox[0].pics.split(",");
            }else{
                res.data.msgBox[0].image=["static/image/400.gif"];
            }

            for (let x=1;x<=5;x++){
              res.data.msgBox[0]["star"+x]=parseInt(res.data.msgBox[0]["star"+x]);
            }
            if(res.data.msgBox[0].views!='0'){
                that.nowStar=(5*res.data.msgBox[0].star5+4*res.data.msgBox[0].star4+3*res.data.msgBox[0].star3+2*res.data.msgBox[0].star2+res.data.msgBox[0].star1)/parseInt(res.data.msgBox[0].views);
            }
            that.dates=res.data.msgBox[0];

        }
        else{
            this.$message('id错误!');
            this.$router.push({path:"/pickpage/"});
        }
              this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
                        loadingInstance1.close();
                      });

           let datesA={
             "title":that.dates.sname,
             "desc":"内江史上最全的美食地图,没有之一!",
             "image":"http://weixin.scnjnews.com/foods/"+that.dates.image[0],
             "link":"http://weixin.scnjnews.com/foods/#/shop/"+this.$route.params.id,
           }
          this.$refs.share.share(datesA);

      },(e)=>{
          this.$message('网络错误!');
      })

    }
  }
</script>
<style scoped>
.inShort {
  text-indent: 20px;
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

.left-box{
  display: flex;
flex-direction: column;
}
.left-box>div{

  flex:1;
}
.stars{
  display: flex;
      padding-top: 10px;
}
.left-box{
  flex: 1;
  border-right: 1px solid black;
  height: 80%;
  margin-top:4%;
  text-align: center;
}
.left-box div:nth-child(1){
  line-height: 37px;
  width: 100%;
}
.right-box{

  flex: 1;
  display: flex;
  flex-direction: column;
}
.right-box span{
  display: flex;
    padding-left: 9%;
  flex: 1;
}
.right-box span div:nth-child(1){
  width: 50px;
  padding-right: 8%;
}

input[type=file]{
  display: none !important;
}
.am-u-sm-3{
  width: 26%;
}
.el-rate{
  height: 28px;
  line-height: 28px;
}
.am-img-responsive{

  margin: 0 auto;
height: 240px;
}
.details h3 {
  overflow: hidden;
  margin: 5px 10px;
  padding: 8px 0px;
  border-bottom: 1px solid #E4EAEE;
}

.details h3:last-child {
  border: none;
}

.details small {
  float: right;
}
.tip{
      text-indent: 28px;
  padding: 8px 16px;
background-color: #ecf8ff;
border-radius: 4px;
border-left: 5px solid #50bfff;
margin: 20px 20px;
}
.tip p{
  font-size: 14px;
color: #5e6d82;
}
@media screen and (min-width:640px){
  .right-box span div:nth-child(1){
    width: 72px !important;
  }

}


</style>
