<?php
$dDates=(array)json_decode(file_get_contents("php://input"));
$db=new mysqli("192.168.20.104","root","102098hchab","weixin");
$preparArray=array(
  "status"=>400
);
switch ($dDates['act']) {
  case 'getGoods':
    $endIn=$dDates['beginWith']+9;
    $preparArray["beginWith"]=$dDates['beginWith'];
    $preparArray["endIn"]=$endIn;

    $sql="select * from festival limit {$dDates['beginWith']},{$endIn}";
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

    $sql="select * from festival where uid='{$uid}' limit 1";
    $re=$db->query($sql);
    $tempArr=[];
    while($res=$re->fetch_array(MYSQLI_ASSOC)){
      $tempArr[]=$res;
    }
    $preparArray["msgBox"]=$tempArr;
    $preparArray["status"]=200;
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
      $sql="select * from festival_record where openid ='{$openid}' limit 1";
      $re=$db->query($sql);
    
      if($re->num_rows==0){
        $time=date("Y-m-d H-i-s",time());
        $sql="INSERT into festival_record (`openid`,`uid`,`time`) values ('{$openid}','{$dDates['uid']}','$time')";
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
