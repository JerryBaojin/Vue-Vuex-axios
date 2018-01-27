<template>
      <div class="f"
      v-loading="cloading"
       element-loading-text="拼命加载中,请稍等"
       element-loading-spinner="el-icon-loading"
       element-loading-background="rgba(0, 0, 0, 0.8)"
      >
            <JsSdk ref="share"/>
            <div id="map" >
            </div>
            <div class="home" @click="toMain">
                <el-button type="primary" round>回到列表</el-button>
            </div>
      </div>
</template>

<script>
import JsSdk from '../components/JsSdk'
  export default{
    components:{
      JsSdk
    },
    name:"DetailsMap",
    data(){
      return {
        cloading:true,
        title:"asd"
      }
    },
    methods:{
      toMain:function(){
        this.$router.push({path:"/pickpage"});
      }
    },
    computed:{
    },
    mounted:function(){

      let dates={
        "title":"甜城味·内江美食地图",
        "desc":"内江史上最全的美食地图,没有之一!",
        "image":"http://weixin.scnjnews.com/foods/share.png",
        "link":"http://weixin.scnjnews.com/foods/#/DetailsMap/all",
      }
     this.$refs.share.share(dates);
      //首先获取数据
      // console.log(typeof(this.$route.params.id));
      // if(typeof(this.$route.params.id)!='number' && this.$route.params.id!='all'){
      //   this.$message("路由错误!");
      //   return false;
      // }
      let that=this;
      let pDates={
        "act":"mapDetails",
        "id":this.$route.params.id
      }
      this.$http.post("api/frontapi.php",pDates).then((res)=>{
        if(res.data.msgBox.length==0){
          this.$message("暂无数据!");
          return false;
        }else{
          let ponits=res.data.msgBox;

          var map = new BMap.Map("map");
          map.addEventListener("tilesloaded",function(){
              that.cloading=false;
          })
          // 创建地图实例
          if(this.$route.params.id=='all'){
              var point = new BMap.Point(105.06648486343,29.593761858443);
          }else{
              let p=JSON.parse(ponits[0].pos).p;
              var point = new BMap.Point(p.lng,p.lat);
          }



          map.addControl(new BMap.NavigationControl());
          // 创建点坐标
          map.centerAndZoom(point, 15);
          map.addControl(new BMap.ScaleControl());
          // 初始化地图，设置中心点坐标和地图级别
          map.addControl(new BMap.MapTypeControl({type:BMAP_MAPTYPE_CONTROL_HORIZONTAL,mapTypes:[BMAP_NORMAL_MAP ,BMAP_SATELLITE_MAP]}));
          map.enableScrollWheelZoom(true);
          map.setCurrentCity("内江");

          map.centerAndZoom(point, 15);

          let mapPonits=[];


      ponits.map((v)=>{
        //插入元素  首先hide,再计算店名div的width
        //根据width 加载图片
        let name='';
        let p=JSON.parse(v.pos).p;
        let  points= new BMap.Point(p.lng,p.lat);

        var html2 = `
<div class="target" id="${v.uid}div" style="display:none;position: absolute; margin: 0pt; padding: 0pt; width: 80px; height: 26px; left: -10px; top: -35px; overflow: hidden;">
    <img id="rm3_image" style="border:none;left:0px; top:0px; position:absolute;" src="static/images/bg.jpg">
</div>
<label class=" BMapLabel" unselectable="on" style="position: absolute; -moz-user-select: none; display: inline; cursor: inherit; border: 0px none; padding: 2px 1px 1px; white-space: nowrap; font: 26px arial,simsun; z-index: 80; color: rgb(255, 102, 0); left: 15px; top: -35px;">
  <div class="ico" id="${v.uid}image">

  </div>
 <span id="${v.uid}span" class="ifont">${v.sname}</span>
</label>
`,
        myRichMarker2 = new BMapLib.RichMarker(html2,points,{
                                                    "anchor" : new BMap.Size(-30, 0),
                                                    "enableDragging" : false,
                                                   });
                                                   let target={
                                                     "uid":v.uid,
                                                     "ponit":myRichMarker2
                                                   }
            map.addOverlay(myRichMarker2);

        let fontWord=parseInt(window.getComputedStyle(document.getElementById(`${v.uid}span`), null).width);
        let imagesL=15;
        let imageR=7;
        let mid=1;
        let mids=fontWord-imagesL-imageR;
        let pre=`  <img  src="static/map/left.png"/>`

        for (let i=1;i<=mids+20;i++){
          pre+=`<img src="static/map/mid.png"/>`;
        }
        pre+=`<img src="static/map/right.png"/>`;
        document.getElementById(`${v.uid}image`).innerHTML=pre;

            mapPonits.push(target);
      })

      for(let i=0;i<mapPonits.length;i++){
        mapPonits[i].ponit.addEventListener("click",function(){
          that.$router.push({path:'/shop/'+mapPonits[i].uid});
        })
      }

      }
    },(e)=>{
        console.log(e)
      })
        }



  }
</script>
<style media="screen">
.home{
  position: fixed;
  bottom: 6%;
  right: 31%;
  color: red;
  font-size: larger;
  font-weight: bold;
}

.home img{
  margin-left: 10%;
}
  html,body,#app,#map,.f{
    height: 100%;
  }
  .ifont{
    position: absolute;
    font-size: 13px;
    font-weight: bold;
    top: 7px;
    right: 12px;
    color: white;
  }
</style>
