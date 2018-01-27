<?php
require_once 'sql.php';
$mysql=new mysql();

$sql="SELECT * FROM tp_websiteurl WHERE id='1'";
$result=$mysql->toresult($sql);
$url=$result[0]['url'];

$token="Eioa5C5oj3S32qhH";
$app="SELECT * FROM tp_diymen_set WHERE token='$token'";
$appinfo=$mysql->toresult($app);

$appid=$appinfo[0]['appid'];
$appsecret=$appinfo[0]['appsecret'];

function https_request($url,$data="")//,
{
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);//请求地址
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//文件流
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//关闭ssl验证

    if ($data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//
    }

    $request=curl_exec($ch);//执行

    $tempArr=json_decode($request,TRUE);
  if (is_array($tempArr)) {
        return $tempArr;
    }
    else
    {
        return $request;
        echo 2;
    }

    curl_close($ch);

}


$uri="$url/foods/frame/frame.php";
$scope='snsapi_base';
$urlb="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=$scope&state=STATE#wechat_redirect";
if(!@$_GET['code']){
    header("Location:$urlb");
    exit;
}
$code=$_GET['code'];


$ass="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";//全局
$c=https_request($ass);
$access=$c['access_token'];//获取全局acess_token

//未关注
$op="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
$oppp=https_request($op);
if(isset($oppp['errcode'])){
	header("location:frame.php");
}else{
$access_token=$oppp["access_token"];
$openid=$oppp['openid'];
}

$sc="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access&openid=$openid";
$userinfo=https_request($sc);
$subscribe=$userinfo['subscribe'];//根据全局acess_token获取信息，如果用户未关注则获取不来详细情况

if ($subscribe==0) {
      header("failure.html");
			return false;
}


$wonder="SELECT * FROM tp_frame WHERE openid='$openid' LIMIT 1";
$re=$mysql->toresult($wonder);
$uid=time();
if(empty($re)){
	$sql="INSERT INTO `festival_comments` (`nickname`, `city`, `sex`,`country`, `province`, `headimgurl`, `openid`,`uid`) VALUES ('{$userinfo['nickname']}', '{$userinfo['city']}', '{$userinfo['sex']}','{$userinfo['country']}', '{$userinfo['province']}', '{$userinfo['headimgurl']}', '$openid','$uid')";
	$re=$mysql->insert($sql);
	if($re){
		header("location:success.php?uid=$uid");
	}
}

?>
