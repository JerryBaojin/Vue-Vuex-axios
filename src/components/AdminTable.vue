<template>
  <div class="">

    <header style="textIndent: 20px;fontSize: 27px;">
      市中区报名人数:{{counts.a}},
      东兴区报名人数:{{counts.b}},
      隆昌市报名人数:{{counts.c}},
      资中县报名人数:{{counts.d}},
      威远县报名人数:{{counts.e}},
      总计报名人数:{{counts.a+counts.b+counts.c+counts.d+counts.e}}
    </header>
  <el-table
    ref="multipleTable"
    :data="sqlDates"
    tooltip-effect="dark"
    style="width: 100%"
    @selection-change="handleSelectionChange">
    <el-table-column
    style="display:none;"
      type="selection"
      width="55">
    </el-table-column>

    <el-table-column
      label="地址"
      width="120">
      <template slot-scope="scope">{{ scope.row.address }}</template>
    </el-table-column>
    <el-table-column
      label="详细地址"
      width="200">
      <template slot-scope="scope">{{ scope.row.detailsAddr }}</template>
    </el-table-column>
    <el-table-column
      label="类型"
      width="120">
      <template slot-scope="scope">{{ scope.row.type }}</template>
    </el-table-column>
    <el-table-column
      label="简介"
      width="500">
      <template slot-scope="scope">{{ scope.row.info }}</template>
    </el-table-column>
    <el-table-column
      label="店名"
      width="200">
      <template slot-scope="scope">{{ scope.row.sname }}</template>
    </el-table-column>
    <el-table-column
      label="手机号"
      width="110">
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


    <el-table-column label="审核">
     <template slot-scope="scope">
         <el-button
           size="mini"
           :type="scope.row.checked=='0'?'danger':'success'"
           @click="handleDelete(scope.row.id,scope.$index)">{{scope.row.checked=='0'?'点击通过':'已经通过'}}
         </el-button>
         <el-button
           size="mini"
           type="danger"
           @click="handleDeleteDetails(scope.row.id,scope.$index)">
           点击删除
         </el-button>
     </template>
   </el-table-column>

   <el-table-column label="删除">
    <template slot-scope="scope">
        <el-button
          size="mini"
          type="danger"
          @click="handleDeleteDetails(scope.row.id,scope.$index)">
          点击删除
        </el-button>
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
        sqlDates:[],
        counts:{"a":0,"b":0,"c":0,"d":0,"e":0}
      }
    },

    methods: {
      handleDeleteDetails(v,i){
        let that=this;
        this.$confirm("确认删除吗?").then((res)=>{
          this.$http.post("api/frontapi.php",{
            "id":v,
            "act":"DeleteDetails"
          }).then((res)=>{
            if(res.data.status==200){
                that.sqlDates.splice(i,1);
            }else{
              this.$message("网络错误!");
            }
          },e=>{
            console.log(e)
          })
        },e=>{
          console.log(e);
        })
      },
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
        let token=localStorage.getItem("Item");
        if(token || prompt("token")=="colo"){
          document.getElementById("app").style.maxWidth="100%";
          localStorage.setItem("Item","colo");
          let that=this;
          let dates={
            "act":"getUnsign"
          }

          this.$http.post("api/frontapi.php",dates).then(res=>{
            res.data.msgBox.map((value,index)=>{

              switch (value.address) {
                case "市中区":
                that.counts.a++;
                  break;
                  case "东兴区":
                  that.counts.b++;
                    break;
                    case "隆昌市":
                    that.counts.c++;
                      break;
                      case "资中县":
                      that.counts.d++;
                        break;
                        case "威远县":
                        that.counts.e++;
                          break;
                default:
              }


              if(value.pics!=''){
                  res.data.msgBox[index].image=value.pics.split(",");
              }else{
                  res.data.msgBox[index].image=["static/image/400.gif"];
              }
              res.data.msgBox[index].star=Math.round(value.star/value.views);
            })
              that.sqlDates=res.data.msgBox;
              //统计人数
          console.log(that.counts)
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
