<template>
  <div class="">


  <el-table
    ref="multipleTable"
    :data="sqlDates"
    tooltip-effect="dark"
    style="width: 100%"
    @selection-change="handleSelectionChange">
    <el-table-column
      type="selection"
      width="55">
    </el-table-column>
    <el-table-column
      label="id"
      width="40">
      <template slot-scope="scope">{{ scope.row.id }}</template>
    </el-table-column>
    <el-table-column
      label="日期"
      width="100">
      <template slot-scope="scope">{{ scope.row.time }}</template>
    </el-table-column>
    <el-table-column
      label="姓名"
      width="120">
      <template slot-scope="scope">{{ scope.row.name }}</template>
    </el-table-column>
    <el-table-column
      label="评价"
      width="320">
      <template slot-scope="scope">
        五星: {{ scope.row.star5 }},四星: {{ scope.row.star4}},三星: {{ scope.row.star3 }},二星: {{ scope.row.star2}},一星: {{ scope.row.star1}}

      </template>
    </el-table-column>
    <el-table-column
      label="地址"
      width="120">
      <template slot-scope="scope">{{ scope.row.address }}</template>
    </el-table-column>
    <el-table-column
      label="详细地址"
      width="120">
      <template slot-scope="scope">{{ scope.row.detailsAddr }}</template>
    </el-table-column>
    <el-table-column
      label="类型"
      width="120">
      <template slot-scope="scope">{{ scope.row.type }}</template>
    </el-table-column>
    <el-table-column
      label="简介"
      width="120">
      <template slot-scope="scope">{{ scope.row.info }}</template>
    </el-table-column>
    <el-table-column
      label="店名"
      width="60">
      <template slot-scope="scope">{{ scope.row.sname }}</template>
    </el-table-column>
    <el-table-column
      label="手机号"
      width="80">
      <template slot-scope="scope">{{ scope.row.phone }}</template>
    </el-table-column>

    <el-table-column
      label="上传的图片"
      width="600">
      <template slot-scope="scope" class="spe">
        <div class="images" v-for="x in scope.row.image ">
          <img :src="x" style="width:40px;" alt="">
        </div>
  </template>
    </el-table-column>


    <el-table-column label="操作">
     <template slot-scope="scope">

         <el-button
           size="mini"
           :type="scope.row.checked=='0'?'danger':'success'"
           @click="handleDelete(scope.row.id,scope.$index)">通过</el-button>


     </template>
   </el-table-column>

 </el-table>
  </el-table>
  <div style="margin-top: 20px;display:none;">
    <el-button @click="toggleSelection([tableData3[1], tableData3[2]])">切换第二、第三行的选中状态</el-button>
    <el-button @click="toggleSelection()">取消选择</el-button>
  </div>
    </div>
</template>

<script>
  export default {
    name:"AdminTable",
    data() {
      return {

        multipleSelection: [],
        sqlDates:[]
      }
    },

    methods: {
      handleDelete(v,i){
        let that=this;
          this.$confirm('确认通过吗？').then(()=>{
              this.$http.post("api/frontapi.php",{
                "id":v,
                "act":"PassChecked"
              }).then((res)=>{
                if(res.data.status==200){
                  that.sqlDates[i]['checked']=1;
                }else{
                  this.$message("网络错误!");
                }
              },e=>{
                console.log(e)
              })


          },(e)=>{
            console.log(e);
          })
          console.log(i);
      },
      toggleSelection(rows) {
        if (rows) {
          rows.forEach(row => {
            this.$refs.multipleTable.toggleRowSelection(row);
          });
        } else {
          this.$refs.multipleTable.clearSelection();
        }
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      }
    },mounted:function(){

        if(prompt("token")=="colo"){
          document.getElementById("app").style.maxWidth="100%";
          let that=this;
          let dates={
            "act":"getUnsign"
          }

          this.$http.post("api/frontapi.php",dates).then(res=>{
            res.data.msgBox.map((value,index)=>{
              if(value.pics!=''){
                  res.data.msgBox[index].image=value.pics.split(",");
              }else{
                  res.data.msgBox[index].image=["static/image/400.gif"];
              }
              res.data.msgBox[index].star=Math.round(value.star/value.views);
            })
              that.sqlDates=res.data.msgBox;
              console.log(that.sqlDates);
          },(e)=>{
            console.log(e)
          })
        }


    }
  }
</script>
<style>
.images {
  display: inline-block;
}
.images img{
  width: 159px !important;
  height: 89px !important;
}
.cell{
  display: flex;
}
.cell div{
  flex: 1;
}
</style>
