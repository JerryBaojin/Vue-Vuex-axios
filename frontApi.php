<?php
$dDates=(array)json_decode(file_get_contents("php://input"));
$db=new mysqli("192.168.20.104","root","102098hchab","weixin");
$preparArray=array(
  "status"=>400
);
switch ($dDates['act']) {
  case 'PassChecked':
    $sql="UPDATE  festival set `checked`='1' where id='{$dDates['id']}'";
    $re=$db->query($sql);
    if($re){
        $preparArray["status"]=200;
    }else{
        $preparArray["status"]=400;
    }

    break;

  case 'getUnsign':
    $sql="select * from festival";
    $re=$db->query($sql);
    $tempArr=[];
    while($res=$re->fetch_array(MYSQLI_ASSOC)){
      $tempArr[]=$res;
    }
    $preparArray["msgBox"]=$tempArr;
    $preparArray["status"]=200;

    break;
  case 'getAll':
      $sql="select * from festival where checked='1'";
      $re=$db->query($sql);
      $tempArr=[];
      while($res=$re->fetch_array(MYSQLI_ASSOC)){
        $tempArr[]=$res;
      }
      $preparArray["msgBox"]=$tempArr;
      $preparArray["status"]=200;

      break;
  case 'getGoods':
    $endIn=10;//fetch ten rows
    $preparArray["beginWith"]=$dDates['beginWith'];
    $preparArray["endIn"]=$endIn;

    $dDates["type"]=="全部"?$dDates["type"]="*":null;


    $sql="select {$dDates["type"]} from festival  where checked='1' limit {$dDates['beginWith']},{$endIn}";

    $re=$db->query($sql);
    $tempArr=[];
    while($res=$re->fetch_array(MYSQLI_ASSOC)){
      $tempArr[]=$res;
    }
    $preparArray["msgBox"]=$tempArr;
    $preparArray["status"]=200;
    break;
  case 'getOneDetails':
    $uid=$dDates['uid']->id;
    if($dDates['openid']=='null'){
        $preparArray["tem"]=100;

    }
    $sql="select * from festival where uid='{$uid}' and checked='1' limit 1";
    $re=$db->query($sql);
    if($re->num_rows==0){
        $preparArray["status"]=400;
        echo json_encode($preparArray);
        return false;
    }
    $tempArr=[];
    while($res=$re->fetch_array(MYSQLI_ASSOC)){
      $tempArr[]=$res;
    }
    $preparArray["msgBox"]=$tempArr;
    $preparArray["status"]=200;


    //查询是否评价过了
    $sql="select * from festival_record where openid='{$dDates['openid']}' and uid='$uid' limit 1";
    $re=$db->query($sql);

    if($re->num_rows!=0){
        $preparArray["time"]=303;
    }else{
        $preparArray["time"]=200;
    }
    break;
  case 'makeComments':
  //
    $openid=$dDates['openid'];
    $sql="select * from festival_comments where openid ='{$openid}' limit 1";
    $re=$db->query($sql);
    if($re->num_rows==0){
      $preparArray["status"]=304;
      $preparArray["msgBox"]="未找到用户信息";
    }else{
      //query the record table
      $uid=$dDates['uid'];

      $sql="select * from festival_record where openid ='{$openid}' and uid='{$uid}' limit 1";
      $re=$db->query($sql);

      if($re->num_rows==0){
        $time=date("Y-m-d H-i-s",time());
        $sql="INSERT into festival_record (`openid`,`uid`,`time`,`star`) values ('{$openid}','{$dDates['uid']}','$time','{$dDates['star']}')";
        $res=$db->query($sql);
        if($res){
          $preparArray["status"]=200;
          $preparArray["msgBox"]="评论成功!";
        }
      }else{
        $preparArray["status"]=303;
        $preparArray["msgBox"]="已经评论过!";
      }
    }

    break;
  default:
    break;
}
echo json_encode($preparArray);

 ?>
