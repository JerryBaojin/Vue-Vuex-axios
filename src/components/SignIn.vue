<template id="">
  <el-form  :model="form"   ref="form"  label-width="100px">
<JsSdk ref="share"/>
  <el-form-item label="商户名称"  prop="name" :rules="[
      { required: true, message: '商店名称不能为空'}
    ]"
    >
    <el-input v-model="form.name" class="short" name="sname"  type="text" :maxlength="20"></el-input>
  </el-form-item>

  <el-form-item label="商户位置"  prop="detailsAddr" :rules="[
      { required: true, message: '商铺位置不能为空'}
    ]"
    >
    <el-input v-model="form.detailsAddr" class="short" name="detailsAddr"  type="text" :maxlength="20"></el-input>
  </el-form-item>


  <el-form-item label="所属区域"  prop="address" :rules="[
      { required: true, message: '商铺区域不能为空'}
    ]" required>
    <el-select v-model="form.address" name="address" placeholder="请选择商铺区域">
      <el-option label="市中区" value="市中区"></el-option>
      <el-option label="东兴区" value="东兴区"></el-option>
      <el-option label="隆昌市" value="隆昌市"></el-option>
      <el-option label="资中县" value="资中县"></el-option>
      <el-option label="威远县" value="威远县"></el-option>
    </el-select>
  </el-form-item>




  <el-form-item label="餐饮类型"  prop="type" :rules="[
      { required: true, message: '餐饮类型不能为空'}
    ]" required>
    <el-select v-model="form.type" name="type" placeholder="请选择餐饮类型">
      <el-option label="中餐" value="中餐"></el-option>
      <el-option label="火锅(汤锅)" value="火锅(汤锅)"></el-option>
      <el-option label="小吃" value="小吃"></el-option>
      <el-option label="河鲜" value="河鲜"></el-option>
    </el-select>
  </el-form-item>

  <el-form-item label="商户简介" prop="type" :rules="[
      { required: true, message: '商户简介'}
    ]" required>
    <el-input type="textarea" class="short" name="info" v-model="form.desc"></el-input>
  </el-form-item>

  <el-form-item label="地理位置">
    <div id="map" style="height:200px;max-width:320px;">
    </div>
    <div class="">
      当前位置:{{position.p.lat}},{{position.p.lng}};

    </div>
    <div class="">
      详细地址:{{position.details}}
    </div>
  </el-form-item>

  <el-form-item label="店主名称" style="display:none;">
    <el-input v-model="form.uname" class="short" name="uname" type="text" ></el-input>
  </el-form-item>

  <el-form-item label="联系方式" prop="phone" :rules="[
      { required: true, message: '联系方式不能为空'},

    ]" required>
    <el-input v-model="form.phone" class="short" name="phone" type="number" ></el-input>
  </el-form-item>

  <el-upload
  class="upload"
  accept="image/*"
  action="api/api.php"
  :limit="10"
  :on-exceed="handleExceed"
  :on-preview="handlePreview"
  :on-success="handleSuccess"
  :on-remove="handleRemove"
  :before-upload="beforeUpload"
  list-type="picture">
  <el-button size="small" type="primary">点击选择上传图片</el-button>
  <div slot="tip" class="el-upload__tip">只能上传jpg/png文件,不能超过10张</div>
  </el-upload>

  <el-form-item>
    <el-button type="primary" @click.preventDefault="onSubmit('form')">提交信息</el-button>
  </el-form-item>
</el-form>
</template>

<script>
import JsSdk from '../components/JsSdk'
  export default{
    components:{
      JsSdk
    },
    name:"SignIn",
    data() {
      return {
        position:{
            "p":{
              'lat':0,
              "lng":0
            },
            "details":''
          },
        pos:[],
        form: {
          name:'',
          address:'',
          type:'',
          phone:'',
          detailsAddr:'',

        },
          pics:[],
          isDraggled:false,
          removePic:''
      }
      },
    methods: {
      handleExceed:function(res){
        this.$message('最多只能上传10张图片!');
      },
      beforeUpload:function(file){
      // file.size/1000000>=2
      let size=file.size/1000000;
        if(size>=2){
          this.removePic=file.name;
          this.$message("单个文件不能超过2M");
          this.$message("单个文件不能超过2M");
          return false;
        }
      },
      handleSuccess:function(res,file,list){
        this.pics=list;
      },
      handlePreview:function(res){

      },
      handleRemove:function(res,list){

        if(res.name==this.removePic){
          //不处理
          this.removePic='';
          return false;
        }
          this.removePic='';

        let  __this=this;
        let dates={
          "act":"delete",
          "filePath":res.response.path
        }
        this.$http.post("api/api.php",dates).then(res=>{
          __this.pics=list;
        },(e)=>{
          console.log(e);
        })
      },
      onSubmit(formName) {

        this.$confirm("目前暂不支持修改数据,请确认无误后提交!").then(()=>{
          if(!this.isDraggled){
            this.$message("请拖动地图，定位自己的位置!");
            return false;
          }
          let pics=new Array();
          this.pics.map((v)=>{
            pics.push(v.response.path);
          })
          let formDates=new FormData(document.getElementsByTagName("form")[0]);
          formDates.append("pics",pics)
          formDates.append("act","getAll")

          formDates.append("position",JSON.stringify(this.position));
          this.$refs[formName].validate((valid) => {
            if (valid) {
              this.$http.post("api/api.php",formDates).then(res=>{

                if(  res.data==1){
                  this.$message('录入成功!待审核成功后，方可在首页展示！请勿重复提交！')
                }else if(res.data==0){
                  this.$message('已经报过名了!');
                }

              },(e)=>{
                this.$message('上传发生异常!')
              })
            } else {
              this.$message('上传发生异常!')
              return false;
            }
          });
            return false;
        },e=>{
          console.log(e);
          return false;
        })


      },
      resPosition(d){
        let postion=this.position;
        let dates=d;
          postion.p=dates;
          this.$jsonp(`http://api.map.baidu.com/geocoder/v2/?location=${dates['lat']},${dates['lng']}&output=json&pois=0&ak=sabTgEGc8497zQY2x4sN0z13E3CwsnXM&extensions_town=extensions_town&latest_admin=1`).then(res=>{
            postion.details=res.result.formatted_address;

          },e=>{
            console.log(e)
          })
      }

    },
    mounted:function(){
      document.title="大千美食节"
      let datesA={
        "title":"大千美食节",
        "desc":"内江史上最全的美食地图,没有之一!",
      "image":"http://weixin.scnjnews.com/foods/share.png",
        "link":"http://weixin.scnjnews.com/foods/#/SignIn"
      }
     this.$refs.share.share(datesA);

      let that=this;

      var map = new BMap.Map("map");
      // 创建地图实例
      var point = new BMap.Point(105.06648486343,29.593761858443);
      // 创建点坐标
      map.centerAndZoom(point, 15);
      map.addControl(new BMap.ScaleControl());
      // 初始化地图，设置中心点坐标和地图级别
      map.addControl(new BMap.MapTypeControl({type:BMAP_MAPTYPE_CONTROL_HORIZONTAL,mapTypes:[BMAP_NORMAL_MAP ,BMAP_SATELLITE_MAP]}));
      map.enableScrollWheelZoom(true);
      map.setCurrentCity("内江");



      map.centerAndZoom(point, 15);

      var html2 = `<div class="target" style="position: absolute; margin: 0pt; padding: 0pt; width: 160px; height: 26px; left: -10px; top: -35px; overflow: hidden;">
                    <img id="hxnk.gif"  style="border:none;left:0px; top:0px; position:absolute;width:30px;height:28px;" src="static/img/3.png">
				        </div>
	`,
      //
      // marker = new BMapLib.RichMarker(html2,  point,{
      //                                             "anchor" : new BMap.Size(15, 28),
			// 									                          "enableDragging" : true,
      //                                            });

   //     myIcon = new BMap.Icon("static/img/1.png",new BMap.Size(23, 25), {
   //     // 指定定位位置。
   //     // 当标注显示在地图上时，其所指向的地理位置距离图标左上
   //     // 角各偏移10像素和25像素。您可以看到在本例中该位置即是
   //     // 图标中央下端的尖角位置。
   //     anchor: new BMap.Size(10, 25),
   //
   //     // 设置图片偏移。
   //     // 当您需要从一幅较大的图片中截取某部分作为标注图标时，您
   //     // 需要指定大图的偏移位置，此做法与css sprites技术类似。
   //
   // });
   //
 marker = new BMap.Marker(point);        // 创建标注

 var opts = {
     width : 50,     // 信息窗口宽度
     height: 5,     // 信息窗口高度
     title : ""  // 信息窗口标题
 }
 var infoWindow = new BMap.InfoWindow("拖动此图标进行定位", opts);  // 创建信息窗口对象

 map.openInfoWindow(infoWindow, point);
      map.addOverlay(marker);
      marker.enableDragging();
      marker.addEventListener("click", function(e){
      console.log(e);
      })

      //初始化
      this.resPosition(marker.getPosition());

      marker.addEventListener("dragend", function(e){
        that.isDraggled=true
        that.resPosition(e.point);
      })
    }

  }
</script>
<style scoped>
.el-upload__input{
  display: none !important;
}
form{
  max-width: 640px;
  margin: 0 auto;
}
  .short,.el-upload-list__item{
    max-width:320px;
  }
  .upload{
    margin-bottom: 10px;
  }
  ul li{
    max-width: 320px;
  }

</style>
