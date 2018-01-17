<template id="">
  <el-form ref="form" :model="form"  label-width="80px">

  <el-form-item label="商店名称">
    <el-input v-model="form.name" class="short" name="sname"  type="text" :maxlength="20"></el-input>
  </el-form-item>

  <el-form-item label="商铺地址" label-position="left">
    <el-input v-model="form.area" class="short" name="address"  type="text" :maxlength="20"></el-input>
  </el-form-item>

  <el-form-item label="餐饮类型">
    <el-select v-model="form.type" name="type" placeholder="请选择餐饮类型">
      <el-option label="中餐" value="中餐"></el-option>
      <el-option label="火锅" value="火锅"></el-option>
      <el-option label="小吃" value="小吃"></el-option>
      <el-option label="河鲜" value="河鲜"></el-option>
    </el-select>
  </el-form-item>

  <el-form-item label="商铺简介">
    <el-input type="textarea" class="short" name="info" v-model="form.desc"></el-input>
  </el-form-item>

  <el-form-item label="店主名称">
    <el-input v-model="form.uname" class="short" name="uname" type="text" ></el-input>
  </el-form-item>

  <el-form-item label="联系方式">
    <el-input v-model="form.phone" class="short" name="phone" type="number" ></el-input>
  </el-form-item>

  <el-upload
  class="upload"
  accept="image/*"
  action="/api/upload"
  :limit="3"
  :on-exceed="handleExceed"
  :on-preview="handlePreview"
  :on-success="handleSuccess"
  :on-remove="handleRemove"

  list-type="picture">
  <el-button size="small" type="primary">点击上传</el-button>
  <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，大小不超过500kb,不能超过3张</div>
  </el-upload>

  <el-form-item>
    <el-button type="primary" @click.preventDefault="onSubmit">提交信息</el-button>
  </el-form-item>
</el-form>
</template>

<script>
  export default {
    name:"SignIn",
    data() {
      return {
        pos:[],
        form: {
          name: '',
          area: '',
          date1: '',
          date2: '',
          delivery: false,
          type: '',
          resource: '',
          desc: ''
        },
          pics:[]
      }
      },
    methods: {
      handleExceed:function(res){
        this.$message('最多只能上传三张图片!');

      },
      handleSuccess:function(res,file,list){
        if(res.errorCode==1){
          this.pics.push(res.path)
        }
      },
      handlePreview:function(res){
          console.log(res);
      },
      handleRemove:function(res){
        let dates={
          "act":"delete",
          "filePath":res.response.path
        }
        this.$http.post("/api/upload",dates).then(res=>{
          console.log(res)
        },(e)=>{
          console.log(e);
        })
      },
      onSubmit() {
        let formDates=new FormData(document.getElementsByTagName("form")[0]);
        formDates.append("pics",this.pics)
        formDates.append("act","getAll")

          this.$http.post("/api/upload",formDates).then(res=>{

            if(  res.data==1){
              this.$message('提交成功!')
            }else if(res.data==0){
              this.$message('已经报过名了!');
            }

          },(e)=>{
            this.$message('上传发生异常!')
          })
      }
    },
    mounted:function(){

    }

  }
</script>
<style scoped>
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
