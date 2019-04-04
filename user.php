<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>投票系统用户页面</title>
</head>
<body>
<center>
<?php
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
	echo "<tr><td align='right'>用户名：</td><td><input type='text' name='lg_u' id='lg_u' value='' /></td></tr>";
	echo "<tr><td align='right'>密&nbsp;&nbsp;&nbsp;&nbsp;码：</td><td><input type='password' name='lg_p' id='lg_p' value='' /></td></tr>";
	echo "<tr><td></td><td><input type='submit' value='登录' /><!--<a href=' ?func=register' style='float:right;'>预注册</a>--></td></tr>";
	echo "</table></form>";
	echo "<p style='font-weight:bold;color:lightgray;'>临时用户：guest，guest密码：123。<br/>现在是公开测试版</p>";
}
elseif($_GET["func"]=="register")
{
	echo "<h1>用户注册界面</h1>";
	echo "<form action='?func=rsrn' method='post' id='form_login' name='form_login'>";
	echo "<input type='submit' value='注册' />";
	echo "</form>";
	
}
elseif($_GET["func"]=="lgrn")
{
	setcookie("tp_loginuser","",time()-3600);
	setcookie("tp_loginname","",time()-3600);
	setcookie("tp_usertel","",time()-3600);
	setcookie("tp_usermail","",time()-3600);
	setcookie("tp_limit",false,time()-3600);
	if($_POST["lg_u"]==null)
	{
		alerr("用户名不能为空！",1);
	}
	elseif($_POST["lg_p"]==null)
	{
		alerr("用户密码不能为空！",1);
	}
	include("../data/sqlite3.php");
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	$db=new DataBase("sqlite3db/toupiao.db");
/****tp_users***************************************************************************************************************
  tpu_id      |    tpu_name   |   tpu_alias     |  tpu_pass      |  tpu_tel         |   tpu_mail        | tpu_bakinfo
----------------------------------------------------------------------------------------------------------------------------
 投票用户ID号 |  投票用户名   | 投票用户显示名  | 投票用户密码   |  投票用户手机号  | 投票用户电子邮箱  | 投票用户备注信息
***************************************************************************************************************************/	
	if(!$uif=$db->query("select tpu_name,tpu_admin,tpu_alias,tpu_pass from tp_users where tpu_name='".$_POST["lg_u"]."'"))
	{
		alerr("用户名不存在！",1);
	}
	$uinfo=$uif->fetchArray();
	if($uinfo["tpu_pass"]!=sha1($_POST["lg_p"]))
	{
		alerr("用户密码错误！",1);
	}
	elseif($uinfo["tpu_admin"]==false)
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
		alerr("用户登录成功！有效时间为5分钟。",0);
	}
}
elseif($_GET["func"]=="rsrn")
{
	echo "rsrn";
}
elseif($_GET["func"]==null)
{
	header("Location: ?func=login");
}
?>
</center>
<iframe style="position:fixed;left:0px;width:100%;bottom:0px;height:200px;" src="http://lyclub.f3322.net:82/quan_ping_liu_yan/index.php?url=<?php echo "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; ?>" ></iframe>
</body>
</html>