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

  default:
    # code...
    break;
}
echo json_encode($preparArray);

 ?>
