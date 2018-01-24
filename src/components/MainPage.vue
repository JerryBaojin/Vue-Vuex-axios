<template>
    <div class="op" style="height:100%;">
    <JsSdk ref="share"/>
      <div class="title"><img src="static/images/title.png"></div>
      <div class="szq"><a href="javascript:void(0)" @click="toMain('市中区')"><img src="static/images/szq.png"></a></div>
      <div class="dxq"><a href="javascript:void(0)"  @click="toMain('东兴区')"><img src="static/images/dxq.png"></a></div>
      <div class="zzx"><a href="javascript:void(0)"  @click="toMain('资中县')"><img src="static/images/zzx.png"></a></div>
      <div class="wyx"><a href="javascript:void(0)"  @click="toMain('威远县')"><img src="static/images/wyx.png"></a></div>
      <div class="lcs"><a href="javascript:void(0)"  @click="toMain('隆昌市')"><img src="static/images/lcs.png"></a></div>
      <div class="map"><a href="javascript:void(0)"  @click="toMap"><img src="static/images/map.png"></a></div>
    </div>
</template>



<script>
import JsSdk from '../components/JsSdk'

export default {
  components:{
    JsSdk
  },
  name: 'MainPage',
  data () {
    return {
      value: ''
    }
  },
  methods:{
    toMain:function(t){
        this.$store.commit("newPart",t);
        this.$router.push({path:'/pickpage'});
        document.getElementsByTagName("body")[0].style.background="";
    },
    toMap:function(){
        this.$router.push({path:'/DetailsMap/all'});
        document.getElementsByTagName("body")[0].style.background="";
    }
  },
  mounted:function(){
document.getElementsByTagName("body")[0].style.backgroundImage="url(static/images/bg.jpg)";
document.getElementsByTagName("body")[0].style.backgroundPosition="bottom";
document.getElementsByTagName("body")[0].style.backgroundRepeat="no-repeat";
document.getElementsByTagName("body")[0].style.backgroundSize="100%";
document.title="甜城味·内江美食地图";

    let dates={
      "title":"甜城味·内江美食地图",
      "desc":"内江史上最全的美食地图,没有之一!",
      "image":"http://weixin.scnjnews.com/foods/share.png",
      "link":"http://weixin.scnjnews.com/foods/#/",
    }
   this.$refs.share.share(dates);
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >
*{margin:0;padding: 0}
html,body,#app{height:100%}
body{ background:#3dc7f8;background-position:bottom;background-repeat: no-repeat; background-size: 100%;}
@media screen and (min-width: 380px) {
.title{margin:0 auto;width:320px;padding:60px 0px 20px}
.title img{width:100%;}
.szq,.dxq,.zzx,.wyx,.lcs{width:120px; margin:30px auto 0px;}
.szq img,.dxq img,.zzx img,.wyx img,.lcs img{width:100%; text-align: center;}
.map{width:200px;margin:30px auto 30px}
.map img{width:200px; text-align: center;}
}

@media screen and (max-width: 380px) {
.title{margin:0 auto;width:80%;padding:40px 0px 10px}
.title img{width:100%;}
.szq,.dxq,.zzx,.wyx,.lcs{width:110px; margin:12px auto 0px;}
.szq img,.dxq img,.zzx img,.wyx img,.lcs img{width:100%; text-align: center;}
.map{width:180px;margin:20px auto 30px}
.map img{width:100%; text-align: center;}
}

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
