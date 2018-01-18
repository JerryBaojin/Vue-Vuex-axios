<template>
  <div class="am-g">

    <div class="banner">

          <div class="block">

           <el-carousel height="240px" style="overflow:hidden;">
             <el-carousel-item v-for="item of dates.image" :key="item">
               <h3>    <img :src="'../'+item" class="am-img-responsive" alt="" /></h3>
             </el-carousel-item>
           </el-carousel>
         </div>


    </div>
    <div class="col-sm-12" style="background:white;">
      <h1 class="am-text-center">{{dates.uname}}</h1>
      <hr />
      <div class="am-g">

        <span class="am-u-sm-3 am-text-right">综合评价</span>
        <el-rate
          v-model="nowStar"
          disabled
          show-score
          void-color=""
          text-color="#ff9900"
         score-template="{value}">
        </el-rate>
        <span class="am-u-sm-3 am-text-right"><small>热度{{dates.views}}</small></span>
      </div>
      <hr />
      <div class="am-margin-horizontal-lg details">
        <h3>地址：<small>{{dates.address}}</small></h3>
        <h3>电话：<small><a :href="'tel:'+dates.phone">{{dates.phone}}<span class="am-icon-angle-right am-margin-left-sm"></span></a></small></h3>
        <h3>类型：<small>{{dates.type}}</small></h3>
        <h3>热度：<small><span>{{dates.views}}</span></small></h3>
        <h3>简介：
            <div class="tip am-margin-horizontal-lg">
              <p>{{dates.info}}</p>
            </div>
          </h3>
      </div>



      <hr />
      <h4 class="am-margin-horizontal-lg" v-if="ableToComments">点击评价：
        <el-rate  @change="change"  :disabled="ableComments"  aria-valuenow="1" v-model="commentStar" ></el-rate>
      </h4>
    </div>
    <div class="am-topbar-fixed-bottom am-margin-horizontal-sm am-margin-bottom-sm">
      <button type="button" class="am-btn am-btn-warning am-btn-block">优惠券</button>
    </div>

  </div>
</template>
<script>
import { Loading } from 'element-ui';
  export default{
    name:"ShopDetails",
    data(){
      return {
        commentStar:3.4,
        ableComments:false,
        nowStar:0,
        ableToComments:true,
        dates:''
      }
    },
    computed:{

    },
    methods:{
      change:function(e){
        let openid=localStorage.getItem("openid");
        let times=this.dates['uid'];
        let that=this;
        //localStorege
        this.$confirm('确认评论吗？').then(()=>{
            this.$http.post("api/frontapi.php",{"act":"makeComments","openid":openid,"uid":times,"star":e}).then(res=>{
            switch (res.data.status) {
              case 304:
                //location.href="main.php";
                  this.$message("未找到用户信息!");
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
            //update components status
        //    that.ableComments=true;

        })
        .catch(e=>{
          console.log(e)
        })
      }
    },
    mounted:function(){

      let loadingInstance1 = Loading.service({ fullscreen: true });

      let that=this;
      let openid=localStorage.getItem("openid");

      this.$http.post("api/frontapi",{"act":"getOneDetails","uid":this.$route.params,"openid":openid}).then((res)=>{

        if(res.data.status==200){

          if(res.data.time==303){

              that.ableToComments=false;
          }
            if(res.data.msgBox[0].pics!=''){
                res.data.msgBox[0].image=res.data.msgBox[0].pics.split(",");
            }else{
                res.data.msgBox[0].image="../static/image/400.gif";
            }

            if(res.data.msgBox[0].views!='0'){
                that.nowStar=parseInt(res.data.msgBox[0].star)/parseInt(res.data.msgBox[0].views);
            }


            that.dates=res.data.msgBox[0];
              this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
                loadingInstance1.close();
              });
        }else{
            this.$message('id错误!');
            this.$router.push({path:"/pickpage/"});
        }
      },(e)=>{
          this.$message('网络错误!');
      })

      // if(this.$store.state.page){
      //   this.dates=this.$store.state.page;
      // }else{
      //
      // }

    }
  }
</script>
<style scoped>
input[type=file]{
  display: none !important;
}
.am-u-sm-3{
  width: 26%;
}
.el-rate{
  height: 28px;
  line-height: 14px;
}
.am-img-responsive{
  width: 100%;
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
</style>
