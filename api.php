<?php

$dDates=(array)json_decode(file_get_contents("php://input"));
empty($dDates)?$dDates=$_POST:null;
if(empty($dDates)){
  if(!isset($_FILES['file'])){
    header("HTTP/1.1 403 Forbidden");
    return false;
  }
  $dir=date("Y-m-d",time());
  $pathTemp="upload/".$dir;
  if(!file_exists($pathTemp)){
    mkdir($pathTemp,0777,true);
  }
  $data=$_FILES['file'];
  $type=explode(".",$data['name'])[1];
  $name=(string) time().uniqid().".".$type;

  $upAction=move_uploaded_file($data['tmp_name'],$pathTemp."/".$name);
  if($upAction){
    echo json_encode(array(
      "errorCode"=>1,
      "path"=>$pathTemp."/".$name
    ));
  }else{
    echo json_encode(array(
      "errorCode"=>0
    ));
  }
}elseif(isset($dDates['act'])){
  $target=$dDates['filePath'];
  $res=unlink($target);
  echo $res;
}else{
  $db=new mysqli("192.168.20.104","root","102098hchab","weixin");
  $uid=uniqid();
  $sql="INSERT INTO `festival` (`sname`, `address`, `type`, `info`, `name`, `phone`, `pics`, `uid`) VALUES ('{$dDates['sname']}', '{$dDates['address']}', '{$dDates['type']}', '{$dDates['info']}', '{$dDates['uname']}', '{$dDates['phone']}','{$dDates['pics']}','{$uid}')";
  $db=$db->query($sql);
  echo $db;
}


// $date=$_FILES;
// switch ($date) {
// case "picUpload":
//
//   break;
//
// case "infosUpload":
// $db=new mysqli("192.168.20.104","root","981020hchab","weixin");
// $dates=$_REQUEST;
//   $sql="INSERT INTO `festival` (`name`, `phone`, `detailsAddr`, `type`, `imgPath`, `locationInfos`) VALUES ('{$dates['name']}', '{$dates['phone']}', '{$dates['addr']}', '{$dates['type']}', '{$dates['imgPath']}', '{$dates['location']}')";
// break;
// default:
//   # code...
//   break;
// }


  ?>
