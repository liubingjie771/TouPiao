<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<meta version="<?php include("version.inc"); ?>" />
<title>删除投票项目</title>
</head>
<body>
<?php

if($_COOKIE["tp_loginuser"]!="admin")
{
		echo "<script>window.alert('用户无权删除！');history.go(-1);</script>";
		exit(0);
}
function alerr($a,$b)
{
	//$a弹出：错误信息
	//$b 0进入list.php，1返回表单
	echo "<script language='javascript'>";
	if($a!="")
	{
		echo "window.alert('".$a."');";
	}
	switch($b)
	{
		case "1" : echo "history.go(-1);"; break;
		case "2" : echo "window.close();"; break;
		case "3" : echo "location.href='user.php';"; break;
		case "4" : echo "location.href='admin_list.php';"; break;
	}
	echo "</script>";
	if($b!=0)
		exit(0);
}
if($_COOKIE["tp_loginuser"]==null&&$_COOKIE["tp_limit"]==null)
{
	alerr("本页面授权的用户可以操作！",3);
}

	include("../data/sqlite3.php");
	ini_set('display_errors',0);            //错误信息1
	ini_set('display_startup_errors',0);    //php启动错误信息1
	error_reporting(0);                    //打印出所有的 错误信息-1
	$db=new DataBase("sqlite3db/toupiao.db");
	
	$tp_id=$_GET["tp_id"];
	if($db->exec("delete from tp_mlst where tp_id=".$tp_id))
	{
		alerr("删除选项成功！",0);
		if($db->exec("delete from tp_mulu where tp_id=".$tp_id))
			alerr("删除项目成功！",4);
		else
			alerr("删除项目失败！",1);
	}
	else
		alerr("删除选项失败！",1);
?>
</body>
</html>