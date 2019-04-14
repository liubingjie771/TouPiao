<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<meta version="<?php include("version.inc"); ?>" />
<title>投票系统用户页面</title>
<style type="text/css">
.input_text_red
{
	border-bottom:solid 1px red;
	border-top:none;
	border-left:none;
	border-right:none;
}
.input_text_blue
{
	border-bottom:solid 1px blue;
	border-top:none;
	border-left:none;
	border-right:none;
}
</style>
</head>
<body>
<center>
<?php
//注册时使用的REGID信息
$regid="ABC"."B60E0DDC080B9591F8FD422BF8C03B4A70C42625"."DEF";
	include("../data/sqlite3.php");
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	$db=new DataBase("sqlite3db/toupiao.db");
function alerr($a,$b)
{
	//$a弹出：错误信息
	//$b 0进入list.php，1返回表单
	echo "<script language='javascript'>";
	if($a!="")
	{
		echo "window.alert('".$a."');";
	}
	if($b==0)
	{
		echo "location.href='admin_list.php';";
	}
	elseif($b==1)
	{
		echo "history.go(-1);";
	}
	echo "</script>";
	exit(0);
}
if($_GET["func"]=="login")
{
	echo "<h1>用户登录界面</h1>";
	echo "<form action='?func=lgrn' method='post' id='form_login' name='form_login'>";
	echo "<table border='0'>";
	echo "<tr><td align='right'>用户名：</td><td><input type='text' name='lg_u' id='lg_u' value='' class='input_text_blue'/></td></tr>";
	echo "<tr><td align='right'>密&nbsp;&nbsp;&nbsp;&nbsp;码：</td><td><input type='password' name='lg_p' id='lg_p' value=''  class='input_text_blue'/></td></tr>";
	echo "<tr><td></td><td><input type='submit' value='登录' /></td></tr>";
	echo "</table></form>";
	echo "<p style='font-weight:bold;color:lightgray;'>临时用户：guest，guest密码：123。<br/>现在是公开测试版</p>";
	echo "\n<form action=' ?func=register&regid=".$regid."' method='post'>请输入邀请码<input type='text' name='yqm' id='yqm' value='' size='8' title='管理员用户提供的邀请码' style='height:12px;border-top:none;border-left:none;border-right:none;border-bottom:solid 1px blue;' />进行用户<input type='submit' value='注册' style='border:0px;background:white;color:blue;font-size:16px;margin:0px;padding:0px;font-weight:bold;' title='点击此处注册用户'/></form>\n";
}
elseif($_GET["func"]=="lgrn")
{
	setcookie("tp_loginuser","",time()-3600);
	setcookie("tp_loginname","",time()-3600);
	setcookie("tp_usertel","",time()-3600);
	setcookie("tp_usermail","",time()-3600);
	setcookie("tp_limit",false,time()-3600);
	setcookie("tp_regid",false,time()-3600);
	if($_POST["lg_u"]==null)
	{
		alerr("用户名不能为空！",1);
	}
	elseif($_POST["lg_p"]==null)
	{
		alerr("用户密码不能为空！",1);
	}
	if(!$uif=$db->query("select tpu_name,tpu_admin,tpu_alias,tpu_pass from tp_users where tpu_name='".$_POST["lg_u"]."'"))
	{
		alerr("用户名不存在！",1);
	}
	$uinfo=$uif->fetchArray();
	if($uinfo["tpu_pass"]!=sha1($_POST["lg_p"]))
	{
		alerr("用户密码错误！",1);
	}
	//tpu_admin   0禁用，1启用
	elseif($uinfo["tpu_admin"]==0)
	{
		alerr("用户状态未启用！",1);
	}
	else
	{
		setcookie("tp_loginuser",$uinfo["tpu_name"],time()+300);
		setcookie("tp_loginname",$uinfo["tpu_alias"],time()+300);
		setcookie("tp_usertel",$uinfo["tpu_tel"],time()+300);
		setcookie("tp_usermail",$uinfo["tpu_mail"],time()+300);
		setcookie("tp_limit",$uinfo["tpu_admin"],time()+300);
		setcookie("tp_regid",$regid,time()+300);
		alerr("用户登录成功！有效时间为5分钟。",0);
	}
}
elseif($_GET["func"]==null&&$_GET["regid"]==null)
{
	header("Location: ?func=login");
}
//$regid="ABC"."B60E0DDC080B9591F8FD422BF8C03B4A70C42625"."DEF";
elseif($_GET["func"]=="register"&&$_GET["regid"]==$regid)
{
	if($_POST["yqm"]!="lyclub2016-891021")
	{
		echo "<script>window.alert('没有此邀请码！');location.href='user.php';</script>";
	}
	echo "<h1>用户注册界面</h1>";
	echo "<form action='?func=rsrn&regid=".$_GET["regid"]."' method='post' id='form_login' name='form_login'>\n";
	echo "<table border='0' cellspacing='0' cellpadding='2'>\n";
	echo "<tr><th>用户姓名：</th><td><input type='text' id='usname' name='usname' value='' class='input_text_red' /></td></tr>\n";
	echo "<tr><th>用户账号：</th><td><input type='text' id='usacc' name='usacc' value='' class='input_text_red' /></td></tr>\n";
	echo "<tr><th>用户密码：</th><td><input type='password' id='uspass' name='uspass' value='' class='input_text_red'/></td></tr>\n";
	echo "<tr><th>确认密码：</th><td><input type='password' id='qypass' name='qypass' value='' class='input_text_red'/></td></tr>\n";
	echo "<tr><th>邮箱地址：</th><td><input type='email' id='usmail' name='usmail' value='' class='input_text_red'/></td></tr>\n";
	echo "<tr><th>手机号码：</th><td><input type='telphone' id='ustellp' name='ustelp' value='' class='input_text_red'/></td></tr>\n";
	echo "</table>\n";
	echo "<p><span style='color:red;font-weight:bold;'>红线</span>为必填项，请输入完点击此处<input type='submit' value='注册' style='margin:0px;padding:0px;border:0px;font-size:18px;background:white;color:blue;font-weight:bold;font-family:黑体;'/></p>\n";
	echo "</form>";
	
}
elseif($_GET["func"]=="rsrn"&&$_GET["regid"]==$regid)
{
	if($_POST["usacc"]==null || $_POST["usname"]==null || $_POST["uspass"]==null || $_POST["qypass"]==null || $_POST["usmail"]==null || $_POST["ustelp"]==null )
	{
		echo "<script>window.alert('红线为必填项，请输入完点击此处注册');history.go(-1);</script>";
		exit(0);
	}
	elseif($_POST["uspass"]!=$_POST["qypass"])
	{
		echo "<script>window.alert('用户密码和确认密码不一致');history.go(-1);</script>";
		exit(0);
	}
	$tuid1=$db->query("select max(tpu_id) as tpid from tp_users ");
	$tuid2=$tuid1->fetchArray();
	$tuid3=$tuid2["tpid"];
	$tuid4=$tuid3;+1;
	$isql="insert into tp_users values(".$tuid4.",'".$_POST["usacc"]."','".$_POST["usname"]."','".sha1($_POST["uspass"])."',0,'".$_POST["ustelp"]."','".$_POST["usmail"]."','')";
	if($db->exec($isq))
	{
		echo "<script>window.alert('用户注册成功！请重新登录');location.href='user.php';</script>";
		exit(0);
	}
	else
	{
		echo "<script>window.alert('用户注册失败！');history.go(-1);</script>";
		exit(0);
	}
}
/****tp_users******************************************************************************************************************************
  tpu_id      |    tpu_name   |   tpu_alias     |  tpu_pass      |  tpu_admin     |  tpu_tel         |   tpu_mail        | tpu_bakinfo
-------------------------------------------------------------------------------------------------------------------------------------------
 投票用户ID号 |  投票用户名   | 投票用户显示名  | 投票用户密码   |  用户管理启用  |投票用户手机号  | 投票用户电子邮箱  | 投票用户备注信息
*******************************************************************************************************************************************/	
?>
</center>
<!--iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe-->
</body>
</html>