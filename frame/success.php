<?php
require_once 'sql.php';
$mysql=new mysql();
if(!isset($_GET['uid'])){
	header("location:receive.php");
}
$id=$_GET['uid'];
$sql="select * FROM tp_frame where uid ='$id' limit 1";
$res=$mysql->toresult($sql);
var_dump($res);
 ?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
		<meta content="yes" name="apple-mobile-web-app-capable">
		<meta content="black" name="apple-mobile-web-app-status-bar-style">
		<meta content="telephone=no" name="format-detection">
		<meta content="email=no" name="format-detection">

		<link rel="stylesheet" type="text/css" href="css/action.css">
		<style type="text/css">
			body {
				background-color: #e5e7e5;
			}

			.main {
				margin: 15px;
				height: 400px;
				border-radius: 5px;
				-webkit-border-radius: 5px;
				background-color: #FFF;
				overflow: hidden;
				position: relative;
			}

			.ticket {
				overflow: hidden;
				position: relative;
				background: #f5a129 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAICAYAAAAWX7TTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKTWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQWaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28AAgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0ST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaOWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHiwmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryMAgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0lYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHiNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYAQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6cwR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBiewhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1cQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqOY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hMWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgohJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSUEko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/pdLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Yb1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7OUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsbdi97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83MDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxrPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1U27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H08PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+Hvqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsGLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjgR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4qriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWYEpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1IreZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/PbFWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYji1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVkVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0IbwDa0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vzDoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+yCW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawto22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtdUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3rO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv9563Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+UPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAACeSURBVHjaYvy6UPM/A5UBEwMNAE0MZSFWISOvHAOrTjIDs5Q1AyOnKMP/H+8Z/r08zfD7+iKGf28uo6olJkxZVAIZ2MzrGRiY2bDI/mf4fXkWw+/zE4n3PrO0LQObVQsOAxkYGBgYGVh10xlY1MKJNJSRiYHVtIKBgYGRYPCwGhUxMLLxEjaUSVibgYlPkbgwZ+NlYJaxZ2BgYGAADAADhR0m6qO6HAAAAABJRU5ErkJggg==) left bottom repeat-x;
				height: 200px;
			}

			.ticket-desc {
				font-size: 30px;
				text-align: center;
				position: relative;
				top: 120px;
				width: 100%;
				color: #FFF;
				position: absolute;
			}

			.ticket-sep {
				color: #d2891f;
			}

			.ticket-expire {
				color: #fbdcbd;
				font-size: 12px;
				position: absolute;
				bottom: 16px;
				width: 100%;
				text-align: center;
			}

			.ticket-btn {
				position: relative;
				top: 19px;
				padding: 0 15px;
			}

			.sec {
				position: absolute;
				top: 170px;
				right: 20px;
				width: 70px;
			}

			.head {
				padding-top: 66px;
				font-size: 22px;
				color: #fa5252;
				text-align: center;
			}

			.weui_mask {
				position: fixed;
				z-index: 1;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				background: rgba(0, 0, 0, 0.8);
			}

			.weui_dialog {
				position: fixed;
				z-index: 13;
				width: 85%;
				top: 50%;
				left: 50%;
				-webkit-transform: translate(-50%, -50%);
				-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
				background-color: #FAFAFC;
				-webkit-backdrop-filter: blur(4px);
				backdrop-filter: blur(4px);
				text-align: center;
				border-radius: 3px;
			}

			.weui_dialog_bd {
				padding: 1.2em 0 .5em;
				font-size: 15px;
				color: #888;
			}

			.weui_dialog_ft {
				position: relative;
				line-height: 42px;
				margin-top: 20px;
				font-size: 17px;
			}

			.weui_dialog_ft:after {
				content: " ";
				position: absolute;
				left: 0;
				top: 0;
				width: 100%;
				height: 1px;
				border-top: 1px solid #D5D5D6;
				-webkit-transform-origin: 0 0;
				-ms-transform-origin: 0 0;
				transform-origin: 0 0;
				-webkit-transform: scaleY(0.5);
				-ms-transform: scaleY(0.5);
				transform: scaleY(0.5);
			}
			.weui_btn_dialog{
				color: #666;
			}
			.ticket-instr h4{
				line-height:30px;
			}
			.ticket-instr p{
				line-height:28px;
			}
		</style>

		<title>领取成功</title>
	</head>

	<body>

		<section class="main">
			<div class="ticket">
				<div class="leave-words-item flex">
					<img src="image/head.png" />
					<div class="head flex-1">
						<strong>小明</strong>
					</div>
				</div>
				<!-- 交互方式：此处动态输出优惠券名称 -->
				<div class="ticket-desc">美食大联盟专享优惠</div>
				<div class="ticket-expire">使用范围：美食大联盟成员商家</div>
				<!-- 交互方式：此处动态输出优惠券过期时间 -->
			</div>
			<div class="ticket-instr">
			<img class="sec" src="image/sec.png" />
				<h4>说明：</h4>
				<p>1.仅限美食大联盟成员商家；</p>
				<p>2.买单时出示此页面给成员商家；</p>
				<p>3.具体折扣按商家制定的相关规定执行；</p>
				<p>4.最终解释权归活动组委会所有。</p>
			</div>

		</section>
	</body>
	<?php
	require_once "../jssdk.php";
$jssdk = new JSSDK("wx6f1fa092a4f5e263","51eb6b33ee16bfa2e213c037f9d4c4f8");
$signPackage = $jssdk->GetSignPackage();
?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<script>
	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: <?php echo $signPackage["timestamp"];?>,
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'onMenuShareQZone'
		]
	});
	var sharelink="http://weixin.scnjnews.com/foods/frame/receive.php";
</script>

<script src="share.js"></script>

</html>
